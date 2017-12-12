<?php


namespace GL\WebsiteAdminBundle\Email;

use GL\WebsiteAdminBundle\Entity\Member;

/**
 * Description of RegistrationMailer
 * 
 * Service s'occupant de l'envoi de mail lors de l'inscription d'un membre.
 *
 * @author Gauthier_LANTOINE
 */
class RegistrationMailer {

    private $mailer;
    private $mailerEmail;

    public function __construct(\Swift_Mailer $mailer, $mailerEmail) {
        $this->mailer = $mailer;
        $this->mailerEmail= $mailerEmail;
        
    }
    
    public function sendMemberRegistrationLogin($password, Member $member)
    {
        $message= new \Swift_Message(
                    'Bienvenue sur le site web la diagonale du fou',
                    'Vous venez d\'être inscrit sur le site la diagonale du fou '.'Pseudo: '.$member->getEmail().'Mot de passe: '.$password
                  );
                  
        $message->addTo($member->getEmail())
                ->addFrom($this->mailerEmail[0]);
        
        $this->mailer->send($message);
                   
    }
    
    public function sendMemberValidation(Member $member)
    {
        $message= new \Swift_Message(
                    'Validation du compte la diagonale du fou',
                    'Votre compte utilisateur sur le site la diagonale du fou vient d\'être validé par un administrateur' 
                  );
                  
        $message->addTo($member->getEmail())
                ->addFrom($this->mailerEmail[0]);
        
        $this->mailer->send($message);
                   
    }
    
    public function sendMemberRegistrationConfirmation(Member $member)
    {
        $message= new \Swift_Message(
                    'Confirmation d\'inscription sur le site la diagonale du fou',
                    'Votre compte utilisateur sur le site la diagonale du fou vient d\'être créé.Il doit encore être validé par un administrateur pour pouvoir être utlilisé sur le site' 
                  );
                  
        $message->addTo($member->getEmail())
                ->addFrom($this->mailerEmail[0]);
        
        $this->mailer->send($message);
                   
    }
    
    public function sendMemberDeletionConfirmation(Member $member)
    {
        $message= new \Swift_Message(
                    'Suppression de votre compte utilisateur sur le site la diagonale du fou',
                    'Votre compte utilisateur sur le site la diagonale du fou vient d\'être supprimé.' 
                  );
                  
        $message->addTo($member->getEmail())
                ->addFrom($this->mailerEmail[0]);
        
        $this->mailer->send($message);
                   
    }
    
    public function sendMemberInvalidationConfirmation(Member $member)
    {
        $message= new \Swift_Message(
                    'Annulation de votre inscription sur le site la diagonale du fou',
                    'Votre compte utilisateur sur le site la diagonale du fou viens d\'être invalidé par un administrateur,'
                    . ' toutes les informations transmises sont par conséquent supprimées.'
                  );
                  
        $message->addTo($member->getEmail())
                ->addFrom($this->mailerEmail[0]);
        
        $this->mailer->send($message);
                   
    }
    
    

}
