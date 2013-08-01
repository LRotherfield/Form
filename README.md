##Additional Form Components

This collection of classes add functionality to the Symfony2 Form component.

###Installation

To install the form component simply add it to your composer.json requirements:

```
"require": {
        "lrotherfield/form": "1.0.x-dev",
}
```

And then run `composer.phar update`

###Hidden entity type

To use the hidden entity type you need to register it as a service in your config.yml or a services.yml file:

```
services:
    lrotherfield.form.type.hidden_entity:
        class: Lrotherfield\Component\Form\Type\HiddenEntityType
        arguments:
            - @doctrine.orm.entity_manager
        tags:
            - { name: form.type, alias: hidden_entity }

```

You can use then use the type with the form builder:

```
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        //...
        ->add('example', 'hidden_entity', array(
                "entity_repository" => "Lrotherfield\\Bundle\\ExampleBundle\\Entity\\ExampleEntity"
            ));
    ;
}
```

The only additional requirement is the "entity_repository" option which must be a fully qualified namespace to
the entity that you want to be used in the transformation