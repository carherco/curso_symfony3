<?php

namespace AppBundle\Security;

use AppBundle\Entity\Evento;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Description of EditarEventoVoter
 *
 * @author carlos
 */
class EditarEventoVoter extends Voter
{
    protected function supports($atributo, $entidad)
    {
        // sólo votar en objetos de tipo EVENTO dentro de este voter
        if ($entidad instanceof Evento) {
            return true;
        }

        return false;
    }

    protected function voteOnAttribute($atributo, $entidad, TokenInterface $token)
    {
        $user = $token->getUser();

        //Gracias al método supports ya sabemos que $entidad es un Evento
//        if($user->getId() == $entidad->getCreador()->getId()){
//          return true;
//        }

        return true;

        
    }

}