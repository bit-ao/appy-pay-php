<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Domain\ValueObjects;

enum PaymentMethod: string
{
    case UMM   = 'UMM';   // Unitel Mobile Money
    case REF   = 'REF';   // Payments by sector (References)
    case FTBAI = 'FTBAI'; // Interbank funds-transfers (BAI)
    case GPO   = 'GPO';   // Gateway de Pagamentos Online
    case eTPA  = 'eTPA';  // eTerminal de Pagamentos Automático
    case SDD   = 'SDD';   // Sistema de Débito Directo
}
