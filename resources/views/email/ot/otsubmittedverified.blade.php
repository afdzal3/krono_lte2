@component('mail::message')

Dear **{{$toname}}**,

Overtime application **{{ $claim }}** for **{{$appname}}** has been {{$extra}}routed to you for your {{$type}}. 

Please click on [Overtime System](https://ot.tm.com.my/) to access Overtime System. 

This is a system generated email from [Overtime System](https://ot.tm.com.my/).
If you have any queries / complaints related to overtime, kindly channel them through [HC SSO Helpdesk](https://precise.tm.com.my/) (IDM Login & Password > Incident Catalog > HCSSO - Helpdesk).
Please do not reply to this email.

@endcomponent
