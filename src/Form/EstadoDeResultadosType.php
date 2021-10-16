<?php

namespace App\Form;

use App\Entity\EstadoDeResultados;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstadoDeResultadosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anho')
            ->add('ventas')
            ->add('costoDeVenta')
            ->add('gananciaBruta')
            ->add('gastosDeAdministracion')
            ->add('gastosDeVenta')
            ->add('costosFinancieros')
            ->add('utilidadAntesDeReservaLegal')
            ->add('reservaLegal')
            ->add('utilidadAntesDeImpuestoSobreLaRenta')
            ->add('gastosPorImpuestos')
            ->add('gananciaDelAnho')
            ->add('diferenciaEnCambioDeConversion')
            ->add('perdidasOGananciasActuariales')
            ->add('otroResultadoIntegral')
            ->add('resultadoIntegralTotal')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EstadoDeResultados::class,
        ]);
    }
}
