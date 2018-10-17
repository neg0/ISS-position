<?php

namespace App\Form;

use App\Model\Coordinate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\NotNull;

class CoordinateType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                Coordinate::FIELD_LAT,
                NumberType::class,
                [
                    'constraints' => [ new NotBlank(), new NotNull() ]
                ]
            )
            ->add(
                Coordinate::FIELD_LNG,
                NumberType::class,
                [
                    'constraints' => [ new NotBlank() ]
                ]
            )
        ;

        $builder->setDataMapper($this);
    }

    /**
     * @param Coordinate $data
     * @param FormInterface[]|\Traversable $forms
     */
    public function mapDataToForms($data, $forms)
    {
        if (null === $data) {
            return;
        }

        $forms = iterator_to_array($forms);
        $forms[Coordinate::FIELD_LAT]->setData($data->getLat());
        $forms[Coordinate::FIELD_LNG]->setData($data->getLng());
    }

    /**
     * @param FormInterface[]|\Traversable $forms
     * @param Coordinate $data
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);

        $data = new Coordinate(
            $forms[Coordinate::FIELD_LAT]->getData(),
            $forms[Coordinate::FIELD_LNG]->getData()
        );
    }
}
