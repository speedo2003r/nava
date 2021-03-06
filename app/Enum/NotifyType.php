<?php
namespace App\Enum;

class NotifyType{
    const NOTIFY = 'notify';
    const CHAT = 'chat';
    const DELEGATERATE = 'delegateRate';
    const NEWORDER = 'newOrder';
    const ACCEPTORDER = 'acceptOrder';
    const CANCELORDER = 'cancelOrder';
    const ASSIGNORDER = 'assignOrder';
    const ARRIVETOORDER = 'arriveToOrder';
    const STARTINORDER = 'startInOrder';
    const ADDINVOICE = 'addInvoice';
    const ADDINVOICENOTES = 'addInvoiceNotes';
    const UPDATEINVOICE = 'updateInvoice';
    const REFUSEINVOICE = 'refuseInvoice';
    const ACCEPTINVOICE = 'acceptInvoice';
    const FINISHORDER = 'finishOrder';
    const NEWORDERDELEGATE = 'newOrderDelegate';
    const NEWMESSAGECONTACT = 'newMessageContact';
}
