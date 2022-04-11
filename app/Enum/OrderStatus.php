<?php
namespace App\Enum;

class OrderStatus{
    const CREATED = 'created';
    const ACCEPTED = 'accepted';
    const PENDING = 'pending';
    const REJECTED = 'rejected';
    const DAILY = 'daily';
    const ONWAY = 'on-way';
    const NEWINVOICE = 'new-invoice';
    const UPDATEINVOICE = 'update-invoice';
    const ACCEPTINVOICE = 'accept-invoice';
    const REFUSEINVOICE = 'refuse-invoice';
    const ARRIVED = 'arrived';
    const INPROGRESS = 'in-progress';
    const FINISHED = 'finished';
    const USERCANCEL = 'user_cancel';
}
