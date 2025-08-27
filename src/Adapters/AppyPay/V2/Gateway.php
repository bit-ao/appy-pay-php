<?php
declare(strict_types=1);
namespace Bit\AppyPay\Adapters\AppyPay\V2;
use Bit\AppyPay\Core\Application\DTO\Payments\CreateChargeInput;
use Bit\AppyPay\Core\Application\DTO\Payments\CreateChargeOutput;
use Bit\AppyPay\Core\Application\DTO\References\CreateReferenceInput;
use Bit\AppyPay\Core\Application\DTO\Refunds\CreateRefundInput;
use Bit\AppyPay\Core\Application\DTO\Reverses\CreateReverseInput;
use Bit\AppyPay\Core\Application\DTO\Funds\CreateTransferInput;
use Bit\AppyPay\Core\Application\DTO\Qr\CreateQrCodeInput;
use Bit\AppyPay\Core\Application\DTO\DirectDebit\CreateMandateInput;
use Bit\AppyPay\Core\Application\DTO\SddCreditor\CreateCreditorAppInput;
use Bit\AppyPay\Core\Application\DTO\Applications\ApplicationAllInput;
use Bit\AppyPay\Core\Contracts\PaymentGatewayPort;
use Bit\AppyPay\Core\Contracts\ChargesPort;
use Bit\AppyPay\Core\Contracts\ReferencesPort;
use Bit\AppyPay\Core\Contracts\RefundsPort;
use Bit\AppyPay\Core\Contracts\ReversesPort;
use Bit\AppyPay\Core\Contracts\FundsTransfersPort;
use Bit\AppyPay\Core\Contracts\AccountsPort;
use Bit\AppyPay\Core\Contracts\QrCodesPort;
use Bit\AppyPay\Core\Contracts\DirectDebitPort;
use Bit\AppyPay\Core\Contracts\SddCreditorAppsPort;
use Bit\AppyPay\Core\Contracts\ApplicationsPort;
use Bit\AppyPay\Core\Domain\Entities\Payment;
use Bit\AppyPay\Core\Domain\Entities\Reference;
use Bit\AppyPay\Core\Domain\Entities\Refund;
use Bit\AppyPay\Core\Domain\Entities\Reverse;
use Bit\AppyPay\Core\Domain\Entities\Transfer;
use Bit\AppyPay\Core\Domain\Entities\Account;
use Bit\AppyPay\Core\Domain\Entities\Balance;
use Bit\AppyPay\Core\Domain\Entities\QrCode;
use Bit\AppyPay\Core\Domain\Entities\Mandate;
use Bit\AppyPay\Core\Domain\Entities\CreditorApplication;
use Bit\AppyPay\Core\Domain\Entities\Application;
use Bit\AppyPay\Core\Domain\Services\ChargeRequestValidator;
use Bit\AppyPay\Core\Domain\Services\PaymentMethodRules;
use Bit\AppyPay\Adapters\Http\HttpClient;
use Bit\AppyPay\Adapters\AppyPay\V2\Mappers\PaymentMapper;
use Bit\AppyPay\Adapters\AppyPay\Common\Mappers\ReferenceMapper;
use Bit\AppyPay\Adapters\AppyPay\Common\Mappers\RefundMapper;
use Bit\AppyPay\Adapters\AppyPay\Common\Mappers\ReverseMapper;
use Bit\AppyPay\Adapters\AppyPay\Common\Mappers\TransferMapper;
use Bit\AppyPay\Adapters\AppyPay\Common\Mappers\AccountMapper;
use Bit\AppyPay\Adapters\AppyPay\Common\Mappers\BalanceMapper;
use Bit\AppyPay\Adapters\AppyPay\Common\Mappers\QrCodeMapper;
use Bit\AppyPay\Adapters\AppyPay\Common\Mappers\MandateMapper;
use Bit\AppyPay\Adapters\AppyPay\Common\Mappers\CreditorApplicationMapper;
use Bit\AppyPay\Adapters\AppyPay\Common\Mappers\ApplicationMapper;

final class Gateway implements PaymentGatewayPort, ChargesPort, ReferencesPort, RefundsPort, ReversesPort, FundsTransfersPort, AccountsPort, QrCodesPort, DirectDebitPort, SddCreditorAppsPort, ApplicationsPort
{
    public function __construct(
        private readonly HttpClient $http,
        private readonly string $apiKey,
        private readonly ?string $apiSecret = null
    ) {}

    // Charges
    public function createCharge(CreateChargeInput $input): CreateChargeOutput
    {
        ChargeRequestValidator::validate($input);

        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];

        $payload = [
            'method'      => $input->method->value,
            'amount'      => ['value' => $input->amount->amountMinor / 100, 'currency' => $input->amount->currency],
            'reference'   => $input->reference,
            'description' => $input->description,
            'callbackUrl' => $input->callbackUrl,
            'returnUrl'   => $input->returnUrl,
            'customer'    => $input->customer,
            'metadata'    => $input->metadata,
        ];

        if ($input->options) {
            if ($input->options->account)        { $payload['account'] = $input->options->account; }
            if ($input->options->payerDocument)  { $payload['payer']['document'] = $input->options->payerDocument; }
            if ($input->options->channel)        { $payload['channel'] = $input->options->channel; }

            if (PaymentMethodRules::allowsExpiration($input->method)) {
                if ($input->options->expiresAt) {
                    $payload['expiresAt'] = $input->options->expiresAt->format(DATE_ATOM);
                } else {
                    $hours = PaymentMethodRules::defaultExpireHours($input->method);
                    if ($hours) {
                        $payload['expiresAt'] = (new \DateTimeImmutable("now +{$hours} hours"))->format(DATE_ATOM);
                    }
                }
            }

            foreach (($input->options->vendor['appypay_v2'] ?? []) as $k => $v) {
                $payload[$k] = $v;
            }
        } else {
            if (PaymentMethodRules::allowsExpiration($input->method)) {
                $hours = PaymentMethodRules::defaultExpireHours($input->method);
                if ($hours) {
                    $payload['expiresAt'] = (new \DateTimeImmutable("now +{$hours} hours"))->format(DATE_ATOM);
                }
            }
        }

        $resp = $this->http->request('POST', '/payments', $headers, $payload);
        return new CreateChargeOutput(PaymentMapper::fromArray($resp));
    }

    public function getCharge(string $id): Payment
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $resp = $this->http->request('GET', '/payments/'.rawurlencode($id), $headers);
        return PaymentMapper::fromArray($resp);
    }

    // References
    public function createReference(CreateReferenceInput $input): Reference
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $payload = [
            'amount'   => ['value' => $input->amount->amountMinor / 100, 'currency' => $input->amount->currency],
            'dueDate'  => $input->dueDate?->format(DATE_ATOM),
            'description' => $input->description,
            'metadata'    => $input->metadata,
        ];
        $resp = $this->http->request('POST', '/references', $headers, $payload);
        return ReferenceMapper::fromArray($resp);
    }

    public function getReference(string $id): Reference
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $resp = $this->http->request('GET', '/references/'.rawurlencode($id), $headers);
        return ReferenceMapper::fromArray($resp);
    }

    // Refunds
    public function createRefund(CreateRefundInput $input): Refund
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $payload = [
            'chargeId' => $input->chargeId,
            'amount'   => $input->amountMinor !== null ? ['value' => $input->amountMinor / 100, 'currency' => 'AOA'] : null,
            'reason'   => $input->reason,
            'metadata' => $input->metadata,
        ];
        $resp = $this->http->request('POST', '/refunds', $headers, $payload);
        return RefundMapper::fromArray($resp);
    }

    public function getRefund(string $id): Refund
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $resp = $this->http->request('GET', '/refunds/'.rawurlencode($id), $headers);
        return RefundMapper::fromArray($resp);
    }

    // Reverses
    public function createReverse(CreateReverseInput $input): Reverse
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $payload = [
            'chargeId' => $input->chargeId,
            'reason'   => $input->reason,
            'metadata' => $input->metadata,
        ];
        $resp = $this->http->request('POST', '/reverses', $headers, $payload);
        return ReverseMapper::fromArray($resp);
    }

    // Funds Transfers
    public function createTransfer(CreateTransferInput $input): Transfer
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $payload = [
            'sourceAccount'      => $input->sourceAccount,
            'destinationAccount' => $input->destinationAccount,
            'amount'             => ['value' => $input->amount->amountMinor / 100, 'currency' => $input->amount->currency],
            'memo'               => $input->memo,
            'metadata'           => $input->metadata,
        ];
        $resp = $this->http->request('POST', '/funds/transfers', $headers, $payload);
        return TransferMapper::fromArray($resp);
    }

    public function getTransfer(string $id): Transfer
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $resp = $this->http->request('GET', '/funds/transfers/'.rawurlencode($id), $headers);
        return TransferMapper::fromArray($resp);
    }

    // Accounts
    public function getAccount(string $id): Account
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $resp = $this->http->request('GET', '/accounts/'.rawurlencode($id), $headers);
        return AccountMapper::fromArray($resp);
    }

    public function getBalance(string $id): Balance
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $resp = $this->http->request('GET', '/accounts/'.rawurlencode($id).'/balance', $headers);
        return BalanceMapper::fromArray($resp);
    }

    // QR Codes
    public function createQrCode(CreateQrCodeInput $input): QrCode
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $payload = [
            'static'  => $input->static,
            'payload' => $input->payload,
            'metadata'=> $input->metadata,
        ];
        $resp = $this->http->request('POST', '/qrcodes', $headers, $payload);
        return QrCodeMapper::fromArray($resp);
    }

    public function getQrCode(string $id): QrCode
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $resp = $this->http->request('GET', '/qrcodes/'.rawurlencode($id), $headers);
        return QrCodeMapper::fromArray($resp);
    }

    // Direct Debit Mandates
    public function createMandate(CreateMandateInput $input): Mandate
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $payload = [
            'debtorAccount' => $input->debtorAccount,
            'creditorId'    => $input->creditorId,
            'scheme'        => $input->scheme,
            'metadata'      => $input->metadata,
        ];
        $resp = $this->http->request('POST', '/sdd/mandates', $headers, $payload);
        return MandateMapper::fromArray($resp);
    }

    public function getMandate(string $id): Mandate
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $resp = $this->http->request('GET', '/sdd/mandates/'.rawurlencode($id), $headers);
        return MandateMapper::fromArray($resp);
    }

    public function revokeMandate(string $id): void
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $this->http->request('POST', '/sdd/mandates/'.rawurlencode($id).'/revoke', $headers, []);
    }

    // SDD Creditor Application
    public function apply(CreateCreditorAppInput $input): CreditorApplication
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $payload = [
            'companyName' => $input->companyName,
            'nif'         => $input->nif,
            'bank'        => $input->bank,
            'metadata'    => $input->metadata,
        ];
        $resp = $this->http->request('POST', '/sdd/creditors/apply', $headers, $payload);
        return CreditorApplicationMapper::fromArray($resp);
    }

    public function getStatus(string $id): CreditorApplication
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $resp = $this->http->request('GET', '/sdd/creditors/'.rawurlencode($id), $headers);
        return CreditorApplicationMapper::fromArray($resp);
    }

    // Applications
    public function createApplication(ApplicationAllInput $input): Application
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $payload = [
            'name'     => $input->name,
            'metadata' => $input->metadata,
        ];
        $resp = $this->http->request('POST', '/applications', $headers, $payload);
        return ApplicationMapper::fromArray($resp);
    }

    public function getApplication(string $id): Application
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type'  => 'application/json',
        ];
        $resp = $this->http->request('GET', '/applications/'.rawurlencode($id), $headers);
        return ApplicationMapper::fromArray($resp);
    }
}
