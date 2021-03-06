<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Admin\Model;

use FOS\UserBundle\Model\UserManagerInterface;
//use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


//use Sonata\AdminBundle\Datagrid\DatagridMapper;
//use Sonata\AdminBundle\Datagrid\ListMapper;
//use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\UserBundle\Admin\Model\UserAdmin as BaseType;

class UserAdmin extends BaseType

{
    protected $userManager;

    /**
     * {@inheritdoc}
     */
    public function getFormBuilder()
    {
        $this->formOptions['data_class'] = $this->getClass();

        $options = $this->formOptions;
        $options['validation_groups'] = (!$this->getSubject() || is_null($this->getSubject()->getId())) ? 'Registration' : 'Profile';

        $formBuilder = $this->getFormContractor()->getFormBuilder($this->getUniqid(), $options);

        $this->defineFormBuilder($formBuilder);

        return $formBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getExportFields()
    {
        // avoid security field to be exported
        return array_filter(parent::getExportFields(), function ($v) {
            return !in_array($v, array('password', 'salt'));
        });
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->add('email')
            ->add('school', null, array('label'=>'School'))
//            ->add('groups')
            ->add('enabled', null, array('editable' => true))
            ->add('locked', null, array('editable' => true))
//            ->add('paid', null, array('label'=>'Оплачен', 'editable' => true))
//            ->add('typeUser', null, array('label'=>'тип пользователя'))
        ;

//        if ($this->isGranted('ROLE_ALLOWED_TO_SWITCH')) {
//            $listMapper
//                ->add('impersonating', 'string', array('template' => 'SonataUserBundle:Admin:Field/impersonating.html.twig'))
//            ;
//        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('id')
            ->add('username')
            ->add('school', null, array('label'=>'School'))
            ->add('locked')
            ->add('email')
//            ->add('groups')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General')
                ->add('username')
                ->add('email')
            ->end()
            ->with('Groups')
                ->add('groups')
            ->end()
            ->with('Profile')
                ->add('dateOfBirth')
                ->add('firstname')
                ->add('lastname')
                ->add('website')
                ->add('biography')
                ->add('gender')
                ->add('locale')
                ->add('timezone')
                ->add('phone')
            ->end()
            ->with('Social')
                ->add('facebookUid')
                ->add('facebookName')
                ->add('twitterUid')
                ->add('twitterName')
                ->add('gplusUid')
                ->add('gplusName')
            ->end()
            ->with('Security')
                ->add('token')
                ->add('twoStepVerificationCode')
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        // define group zoning
//        $formMapper
//            ->tab('User')
//                ->with('Profile', array('class' => 'col-md-6'))->end()
//                ->with('General', array('class' => 'col-md-6'))->end()
////                ->with('Social', array('class' => 'col-md-6'))->end()
//            ->end()
//            ->tab('Security')
//                ->with('Status', array('class' => 'col-md-4'))->end()
//                ->with('Groups', array('class' => 'col-md-4'))->end()
//                ->with('Keys', array('class' => 'col-md-4'))->end()
//                ->with('Roles', array('class' => 'col-md-12'))->end()
//            ->end()
//        ;

        $now = new \DateTime();

        $formMapper
            ->tab('User')
                ->with('General')
                    ->add('username')
                    ->add('email')
                    ->add('plainPassword', 'text', array(
                        'required' => (!$this->getSubject() || is_null($this->getSubject()->getId())),
                    ))
                ->end()
                ->with('Profile')
                    ->add('school', 'entity', array(
                        'empty_value' => '-- Select school --',
                        'class'=>'InfoSchoolBundle:School',
                        'label'=>'Школа'
                    ))
//                    ->add('school')
                    ->add('dateOfBirth', 'sonata_type_date_picker', array(
                        'years'       => range(1900, $now->format('Y')),
                        'dp_min_date' => '1-1-1900',
                        'dp_max_date' => $now->format('c'),
                        'required'    => false,
                    ))
                    ->add('firstname', null, array('required' => false))
                    ->add('lastname', null, array('required' => false))
//                    ->add('website', 'url', array('required' => false))
//                    ->add('biography', 'text', array('required' => false))
                    ->add('gender', 'sonata_user_gender', array(
                        'required'           => true,
                        'translation_domain' => $this->getTranslationDomain(),
                    ))
//                    ->add('locale', 'locale', array('required' => false))
//                    ->add('timezone', 'timezone', array('required' => false))
//                    ->add('phone', null, array('required' => false))
//                    ->add('photo', 'sonata_media_type',
//                        array('required'=>false ,'label' => 'Изображение'),
//                        array('link_parameters' => array('context' =>'avatar'))
//
//                    )
//                    ->add('photo', 'sonata_media_type', array(
//                        'provider' => 'sonata.media.provider.image',
//                        'context' => 'avatar',
//                        'required'=>false,
////                        'validation_groups' => 'Default'
//                    ))
                ->end()
//                ->with('Social')
//                    ->add('facebookUid', null, array('required' => false))
//                    ->add('facebookName', null, array('required' => false))
//                    ->add('twitterUid', null, array('required' => false))
//                    ->add('twitterName', null, array('required' => false))
//                    ->add('gplusUid', null, array('required' => false))
//                    ->add('gplusName', null, array('required' => false))
//                ->end()
            ->end()
        ;

//        if ($this->getSubject() && !$this->getSubject()->hasRole('ROLE_SUPER_ADMIN')) {
//            $formMapper
//                ->tab('Security')
//                    ->with('Status')
//                        ->add('locked', null, array('required' => false))
//                        ->add('expired', null, array('required' => false))
//                        ->add('enabled', null, array('required' => false))
//                        ->add('credentialsExpired', null, array('required' => false))
//                    ->end()
//                    ->with('Groups')
//                        ->add('groups', 'sonata_type_model', array(
//                            'required' => false,
//                            'expanded' => true,
//                            'multiple' => true,
//                        ))
//                    ->end()
//                    ->with('Roles')
//                        ->add('realRoles', 'sonata_security_roles', array(
//                            'label'    => 'form.label_roles',
//                            'expanded' => true,
//                            'multiple' => true,
//                            'required' => false,
//                        ))
//                    ->end()
//                ->end()
//            ;
//        }
//
//        $formMapper
//            ->tab('Security')
//                ->with('Keys')
//                    ->add('token', null, array('required' => false))
//                    ->add('twoStepVerificationCode', null, array('required' => false))
//                ->end()
//            ->end()
//        ;
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($user)
    {
        $this->getUserManager()->updateCanonicalFields($user);
        $this->getUserManager()->updatePassword($user);
    }

    /**
     * @param UserManagerInterface $userManager
     */
    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @return UserManagerInterface
     */
    public function getUserManager()
    {
        return $this->userManager;
    }
}
