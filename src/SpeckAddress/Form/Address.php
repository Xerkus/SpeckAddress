<?php

namespace SpeckAddress\Form;

use Zend\Form\Form;

class Address extends Form
{
    protected $addressService;

    public function init($moduleOptions)
    {
        parent::__construct();

        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Address Label'
            ),
        ));

        $this->add(array(
            'name' => 'street_address',
            'type' => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => 'Street Address'
            ),
        ));

        $this->add(array(
            'name' => 'city',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'City'
            ),
        ));

        $this->add(array(
            'name' => 'province',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'State / Province'
            ),
        ));

        $this->add(array(
            'name' => 'postal_code',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Postal Code',
            ),
        ));

        $this->add(array(
            'name' => 'country',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Country',
            ),
            'attributes' => array(
                'options' => $this->getCountryOptions($moduleOptions),
            ),
        ));
    }

    public function getCountryOptions($moduleOptions = array())
    {
        $countries = $this->getAddressService()->getCountryList();

        $weights = $moduleOptions->getWeightedCountryCodes();
        $spelling = $moduleOptions->getAlternateSpellings();

        $result = array();
        $result[""] = "";
        foreach ($countries as $c) {
            $result[] = array(
                'label' => utf8_encode($c['country']),
                'value' => $c['country_code'],
                'weight' => isset($weights[$c['country_code']]) ? $weights[$c['country_code']] : 1,
                'alt-spelling' => isset($spelling[$c['country_code']]) ? $spelling[$c['country_code']] : '',
            );
        }

        return $result;
    }

    public function getAddressService()
    {
        return $this->addressService;
    }

    public function setAddressService($addressService)
    {
        $this->addressService = $addressService;
        return $this;
    }
}
