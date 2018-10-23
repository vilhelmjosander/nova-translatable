<?php

namespace Spatie\NovaTranslatable\Tests;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\Text;
use Spatie\NovaTranslatable\Translatable;
use Spatie\Tags\Tag;

class TranslatableTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Translatable::defaultLocales(['en', 'fr']);
    }

    /** @test */
    public function it_works_when_passing_no_fields_to_it()
    {
        $translatable = Translatable::make([]);

        $this->assertEquals([], $translatable->data);
    }

    /** @test */
    public function it_will_generate_a_field_per_locale()
    {
        $translatable = Translatable::make([
            new Text('title'),
        ]);

        $this->assertCount(2, $translatable->data);

        $this->assertEquals($translatable->data[0]->name, 'Title (en)');
        $this->assertEquals($translatable->data[1]->name, 'Title (fr)');
    }

    /** @test */
    public function it_accepts_a_closure_to_customize_the_label()
    {
        $translatable = Translatable::make([
            new Text('title'),
        ])->displayLocaleUsing(function(Field $field, string $locale) {
            return $locale . '-' . $field->name;
        });

        $this->assertCount(2, $translatable->data);

        $this->assertEquals($translatable->data[0]->name, 'en-title');
        $this->assertEquals($translatable->data[1]->name, 'fr-title');
    }

    /** @test */
    public function it_will_can_accept_custom_locales()
    {
        $translatable = Translatable::make([
            new Text('title'),
        ])->locales(['es', 'it', 'de']);

        $this->assertCount(3, $translatable->data);

        $this->assertEquals($translatable->data[0]->name, 'Title (es)');
        $this->assertEquals($translatable->data[1]->name, 'Title (it)');
        $this->assertEquals($translatable->data[2]->name, 'Title (de)');
    }


}
