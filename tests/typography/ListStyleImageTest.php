<?php

namespace Raakkan\PhpTailwind\Tests\Typography;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Typography\ListStyleImageClass;

class ListStyleImageTest extends TestCase
{
    #[DataProvider('listStyleImageClassProvider')]
    public function test_list_style_image_class(string $input, string $expected): void
    {
        $listStyleImageClass = ListStyleImageClass::parse($input);
        $this->assertInstanceOf(ListStyleImageClass::class, $listStyleImageClass);
        $this->assertSame($expected, $listStyleImageClass->toCss());
    }

    public static function listStyleImageClassProvider(): array
    {
        return [
            // Predefined value
            ['list-image-none', '.list-image-none{list-style-image:none;}'],

            // Arbitrary values
            ['list-image-[url(checkmark.png)]', '.list-image-\[url\(checkmark\.png\)\]{list-style-image:url(checkmark.png);}'],
            ['list-image-[url("bullet.svg")]', '.list-image-\[url\(\"bullet\.svg\"\)\]{list-style-image:url("bullet.svg");}'],
            ['list-image-[url(\'custom.gif\')]', '.list-image-\[url\(\\\'custom\.gif\\\'\)\]{list-style-image:url(\'custom.gif\');}'],
            ['list-image-[inherit]', '.list-image-\[inherit\]{list-style-image:inherit;}'],
            ['list-image-[initial]', '.list-image-\[initial\]{list-style-image:initial;}'],
            ['list-image-[revert]', '.list-image-\[revert\]{list-style-image:revert;}'],
            ['list-image-[unset]', '.list-image-\[unset\]{list-style-image:unset;}'],
        ];
    }

    public function test_invalid_list_style_image_class(): void
    {
        $this->assertNull(ListStyleImageClass::parse('list-image-invalid'));
    }

    #[DataProvider('invalidArbitraryListStyleImageProvider')]
    public function test_invalid_arbitrary_list_style_image(string $input): void
    {
        $listStyleImageClass = ListStyleImageClass::parse($input);
        $this->assertInstanceOf(ListStyleImageClass::class, $listStyleImageClass);
        $this->assertSame('', $listStyleImageClass->toCss());
    }

    public static function invalidArbitraryListStyleImageProvider(): array
    {
        return [
            ['list-image-[invalid]'],
            ['list-image-[123]'],
            ['list-image-[rgb(255,0,0)]'],
        ];
    }

    #[DataProvider('specialCharactersListStyleImageProvider')]
    public function test_special_characters_list_style_image(string $input, string $expected): void
    {
        $listStyleImageClass = ListStyleImageClass::parse($input);
        $this->assertInstanceOf(ListStyleImageClass::class, $listStyleImageClass);
        $this->assertSame($expected, $listStyleImageClass->toCss());
    }

    public static function specialCharactersListStyleImageProvider(): array
    {
        return [
            ['list-image-[url(image(with)parentheses.png)]', '.list-image-\[url\(image\(with\)parentheses\.png\)\]{list-style-image:url(image(with)parentheses.png);}'],
            ['list-image-[url(image-with-dashes.png)]', '.list-image-\[url\(image-with-dashes\.png\)\]{list-style-image:url(image-with-dashes.png);}'],
            ['list-image-[url(image_with_underscores.png)]', '.list-image-\[url\(image_with_underscores\.png\)\]{list-style-image:url(image_with_underscores.png);}'],
        ];
    }

    public function test_non_list_style_image_class(): void
    {
        $this->assertNull(ListStyleImageClass::parse('font-bold'));
        $this->assertNull(ListStyleImageClass::parse('text-lg'));
        $this->assertNull(ListStyleImageClass::parse('bg-red-500'));
    }

    // #[DataProvider('edgeCaseListStyleImageProvider')]
    // public function testEdgeCaseListStyleImage(string $input, string $expected): void
    // {
    //     $listStyleImageClass = ListStyleImageClass::parse($input);
    //     $this->assertInstanceOf(ListStyleImageClass::class, $listStyleImageClass);
    //     $this->assertSame($expected, $listStyleImageClass->toCss());
    // }

    // public static function edgeCaseListStyleImageProvider(): array
    // {
    //     return [
    //         ['list-image-[url()]', '.list-image-\[url\(\)\]{list-style-image:url();}'],
    //         ['list-image-[url( )]', '.list-image-\[url\(\ \)\]{list-style-image:url( );}'],
    //         ['list-image-[url("")]', '.list-image-\[url\(\"\"\)\]{list-style-image:url("");}'],
    //         ['list-image-[url(\'\')]', '.list-image-\[url\(\'\'\)\]{list-style-image:url(\'\');}'],
    //     ];
    // }

    // public function testCaseInsensitivity(): void
    // {
    //     $lowerCase = ListStyleImageClass::parse('list-image-none');
    //     $upperCase = ListStyleImageClass::parse('LIST-IMAGE-NONE');
    //     $mixedCase = ListStyleImageClass::parse('LiSt-ImAgE-nOnE');

    //     // $this->assertNotNull($lowerCase);
    //     // $this->assertNotNull($upperCase);
    //     // $this->assertNotNull($mixedCase);

    //     $this->assertSame($lowerCase->toCss(), $upperCase->toCss());
    //     $this->assertSame($lowerCase->toCss(), $mixedCase->toCss());
    // }

    public function test_arbitrary_value_case_sensitivity(): void
    {
        $lowerCase = ListStyleImageClass::parse('list-image-[url(image.png)]');
        $upperCase = ListStyleImageClass::parse('list-image-[URL(IMAGE.PNG)]');

        $this->assertNotNull($lowerCase);
        $this->assertNotNull($upperCase);

        $this->assertNotSame($lowerCase->toCss(), $upperCase->toCss());
    }
}
