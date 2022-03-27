<?php
namespace App\Enum;

class OrderStatus{
    const CREATED = 'created';
    const ACCEPTED = 'accepted';
    const ONWAY = 'on-way';
    const ARRIVED = 'arrived';
    const INPROGRESS = 'in-progress';
    const FINISHED = 'finished';
    const USERCANCEL = 'user_cancel';
}
