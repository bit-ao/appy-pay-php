# appy-pay-php

SDK/Helper/Adapter em **PHP puro** para facilitar a integração com a API da **AppyPay** — um facilitador de gateway de pagamento para empresas em Angola.  
As APIs seguem princípios **REST**, com nomenclatura orientada a recursos, e as respostas são em **JSON**.

> ⚠️ **Estado**: Este repositório **esta em desenvolvimento**.

> ⚠️ **Aviso legal**: Este projeto é colaborativo e **não** representa, nem é afiliado, patrocinado, endossado ou associado a quaisquer marcas, bancos, operadoras, gateways, agregadores ou entidades citadas.  
<br>Nomes e logótipos mencionados são propriedade dos seus titulares.
As informações aqui reunidas podem ficar **desatualizadas**. Verifica sempre as **fontes oficiais** antes de decisões técnicas ou comerciais.  
<br> Este material é fornecido “**AS IS**”, sem garantias. **Não** constitui aconselhamento jurídico, financeiro ou fiscal.

---

## 🧱 Arquitectura (Clean/Hexagonal)

- **Core** (estável, sem versão): Entidades, Value Objects, DTOs, Use Cases e Ports (interfaces).
- **Adapters** (versionados): Implementações específicas para a API da AppyPay `V1`, `V2`…
- **GatewayFactory**: escolhe o adapter pela versão configurada.
- **Laravel (opcional)**: ServiceProvider + config para *binding* via IoC.

```
src/
├─ Core/
│  ├─ Domain/{Entities,ValueObjects}
│  ├─ Contracts/
│  └─ Application/{DTO,UseCases}
├─ Adapters/
│  ├─ Http/{HttpClient,CurlHttpClient}
│  └─ AppyPay/{GatewayFactory, V1/*, V2/*}
└─ InterfaceAdapters/Laravel/{AppyPayServiceProvider.php,config/appypay.php}
```

## 📦 Instalação (quando publicar no Packagist)

```bash
composer require <vendor>/appy-pay-php
```

> Substitui `<vendor>` pelo teu vendor (ex.: `bit-ao/appy-pay-php`).

## ⚙️ Configuração rápida (Laravel – opcional)

1. Publica o config: `php artisan vendor:publish --tag=config`
2. Define no `.env`:
```
APPYPAY_BASE_URL=https://api.appypay.ao
APPYPAY_VERSION=v1
APPYPAY_API_KEY=seu_key
APPYPAY_API_SECRET=seu_secret
```

## 🚀 Exemplo rápido (PHP puro)

```php
<?php

use Bit\AppyPay\Adapters\AppyPay\GatewayFactory;
use Bit\AppyPay\Core\Application\Dto\Payments\CreateChargeInput;
use Bit\AppyPay\Core\Domain\ValueObjects\Money;

$gateway = GatewayFactory::make(
    version: 'v1',
    baseUrl: 'https://api.appypay.ao',
    apiKey: 'KEY_AQUI',
    apiSecret: null
);

$input = new CreateChargeInput(
    amount: Money::aoaInt(15000),
    reference: 'PEDIDO-12345',
    description: 'Compra #12345',
    callbackUrl: 'https://teusistema.ao/webhooks/appypay',
    returnUrl: 'https://teusistema.ao/sucesso/12345'
);

$out = $gateway->createCharge($input);
var_dump($out->payment);
```

## 🧪 Testes

```bash
composer install
vendor/bin/phpunit
```

## 📄 Licença

MIT (podes alterar conforme necessidade).


## 🧭 Métodos de pagamento (resumo)
Identificadores aceites: **UMM**, **REF**, **FTBAI**, **GPO**, **eTPA**, **SDD**.  
- `Charges`: UMM, REF, GPO, eTPA, SDD
- `Refunds`: UMM, GPO, eTPA, SDD
- `Reverses`: UMM
- `Funds Transfers`: FTBAI
- `References`: REF
- `Cancellation`: SDD

> Regras: UMM min 50 AOA; GPO/eTPA min 1 AOA; REF permite expiração (default 72h se não for informada); Webhook é **obrigatório em REF** e recomendado/necessário em pedidos assíncronos nos demais.

### Exemplo: criar REF com expiração
```php
use Bit\AppyPay\Core\Application\Dto\Payments\{CreateChargeInput, CreateChargeOptions};
use Bit\AppyPay\Core\Domain\ValueObjects\{Money, PaymentMethod};

$input = new CreateChargeInput(
  amount: Money::aoaInt(10000),
  reference: 'PEDIDO-REF-001',
  method: PaymentMethod::REF,
  callbackUrl: 'https://teu.app/webhook/appypay',
  options: new CreateChargeOptions(expiresAt: new DateTimeImmutable('+72 hours'))
);
$gateway->createCharge($input);
```
