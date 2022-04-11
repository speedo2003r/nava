<?php
namespace App\Enum;

class NotifyType{
    const NOTIFY = 'notify';
    const DELEGATERATE = 'delegateRate';
    const NEWORDER = 'newOrder';
    const ASSIGNORDER = 'assignOrder';
    const ADDINVOICE = 'addInvoice';
    const ADDINVOICENOTES = 'addInvoiceNotes';
    const UPDATEINVOICE = 'updateInvoice';
    const REFUSEINVOICE = 'refuseInvoice';
    const ACCEPTINVOICE = 'acceptInvoice';
    const FINISHORDER = 'finishOrder';
    const NEWORDERDELEGATE = 'newOrderDelegate';
}
