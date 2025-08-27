<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Contracts;

use Bit\AppyPay\Core\Application\DTO\Qr\CreateQrCodeInput;
use Bit\AppyPay\Core\Domain\Entities\QrCode;

interface QrCodesPort
{
    public function createQrCode(CreateQrCodeInput $input): QrCode;
    public function getQrCode(string $id): QrCode;
}
