<?php

namespace AppBundle\Admin;


use AppBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class ChatRoomAdmin
 *
 * @package AppBundle\Admin
 */
class ChatRoomAdmin extends AbstractAdmin
{
    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('id')
            ->add(
                '_actions',
                null,
                [
                    'actions' => [
                        'show' => [],
                        'edit' => [],
                        'delete' => [],
                    ]
                ]);
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add(
                'users',
                EntityType::class,
                [
                    'class' => User::class,
                    'multiple' => true,
                ]
            );
    }


}
