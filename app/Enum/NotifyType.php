<?php
namespace App\Enum;

class NotifyType{
    const NOTIFY = 'notify';
    const DELEGATERATE = 'delegateRate';
    const NEWORDER = 'newOrder';
    const ADDINVOICE = 'addInvoice';
    const UPDATEINVOICE = 'updateInvoice';
    const REFUSEINVOICE = 'refuseInvoice';
    const ACCEPTINVOICE = 'acceptInvoice';
    const FINISHORDER = 'finishOrder';
    const NEWORDERDELEGATE = 'newOrderDelegate';
}
