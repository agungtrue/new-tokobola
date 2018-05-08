<?php

namespace App\Listeners\Loan\Approval;

use App\Events\Loan\Approval;
use App\Support\Realtime\Courier;

class SendNotification
{
    public function handle(Approval $event)
    {
        $mailToMember = [
            'NotificationType' => 'LoanApproval',
            'payload' => [
                'to' => [
                    'address' => $event->Model->Loan->user->email,
                    'name' => $event->Model->Loan->user->name,
                ],
                'data' => []
            ]
        ];
        Courier::send($mailToMember);

        $User = $event->Model->Loan->user;

        $User->member;
        $User->member->company;
        $User->memberFamily;
        $User->memberBank;
        $User->memberCompany;

        $mailToCS = [
            'NotificationType' => 'LoanApproval:TO:CS',
            'payload' => [
                'data' => [
                    'loan' => [
                        'user' => $User,
                        'date' => $event->Model->Loan->created_at,
                        'principal' => $event->Model->Loan->principal,
                        'interest' => $event->Model->Loan->interest,
                        'amount' => $event->Model->Loan->amount,
                        'termInfoType' => $event->Model->Loan->term_type === 'oncepaid' ? 'Sekali Bayar' : 'Cicilan',
                        'termInfoDate' => $event->Model->Loan->term . ' Hari',
                        'term' => $event->Model->Loan->term,
                        'term_type' => $event->Model->Loan->term_type
                    ]
                ]
            ]
        ];

        Courier::send($mailToCS);
    }
}
