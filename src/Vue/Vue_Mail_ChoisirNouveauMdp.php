<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;


class Vue_Mail_ChoisirNouveauMdp  extends Vue_Composant
{
    private string $token;
    public function __construct(string$action, string $token,string $message)
    {
        $this->action = $action;
        $this->token=$token;
        $this->message=$message;
    }


    function donneTexte(): string
    {
        return "  <form action='index.php' method='post' style='    width: 50%;    display: block;    margin: auto;'>


               <h1>Choisissez votre nouveau mdp</h1>
               <input type='hidden' name='token' value='$this->token'>
               <label><b>Compte</b></label>
               <input type='password' placeholder='NouveauPassword' name='NouveauPassword' required>
               <input type='password' placeholder='ConfirmPassword' name='ConfirmPassword' required>
               <button type='submit' id='submit' name='action' value='$this->action'>
                     Confirmer le mdp
               </button>
               <label><b>$this->message</b></label>
           </form>
   ";
    }


}



