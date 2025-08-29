<?php


namespace Bit\AppyPay\Core\Application\Dto\Notify;


class NotifyDto
{
    public function __construct(
        public string $name ,
        public string $telephone,
        public string $email ,
        public bool $smsNotification = false,
        public bool $emailNotification = false,
    ) {}

    public  function toArray():array{
        return [
            "name"=> $this->name,
            "telephone"=>$this->telephone,
            "email"=>$this->email,
            "smsNotification"=>$this->smsNotification,
            "emailNotification"=>$this->emailNotification

        ];
    }
}