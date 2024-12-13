<?php

namespace Raakkan\PhpTailwind\Tests\Backgrounds;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Backgrounds\BackgroundImageClass;

class BackgroundImageTest extends TestCase
{
    #[DataProvider('backgroundImageClassProvider')]
    public function test_background_image_class(string $input, string $expected): void
    {
        $bgImageClass = BackgroundImageClass::parse($input);
        $this->assertInstanceOf(BackgroundImageClass::class, $bgImageClass);
        $this->assertSame($expected, $bgImageClass->toCss());
    }

    public static function backgroundImageClassProvider(): array
    {
        return [
            // Predefined values
            ['bg-none', '.bg-none{background-image:none;}'],
            ['bg-gradient-to-t', '.bg-gradient-to-t{background-image:linear-gradient(to top, var(--tw-gradient-stops));}'],
            ['bg-gradient-to-tr', '.bg-gradient-to-tr{background-image:linear-gradient(to top right, var(--tw-gradient-stops));}'],
            ['bg-gradient-to-r', '.bg-gradient-to-r{background-image:linear-gradient(to right, var(--tw-gradient-stops));}'],
            ['bg-gradient-to-br', '.bg-gradient-to-br{background-image:linear-gradient(to bottom right, var(--tw-gradient-stops));}'],
            ['bg-gradient-to-b', '.bg-gradient-to-b{background-image:linear-gradient(to bottom, var(--tw-gradient-stops));}'],
            ['bg-gradient-to-bl', '.bg-gradient-to-bl{background-image:linear-gradient(to bottom left, var(--tw-gradient-stops));}'],
            ['bg-gradient-to-l', '.bg-gradient-to-l{background-image:linear-gradient(to left, var(--tw-gradient-stops));}'],
            ['bg-gradient-to-tl', '.bg-gradient-to-tl{background-image:linear-gradient(to top left, var(--tw-gradient-stops));}'],

            // Arbitrary values
            ['bg-[url(/img/hero.jpg)]', '.bg-\[url\(/img/hero\.jpg\)\]{background-image:url(/img/hero.jpg);}'],
            ['bg-[linear-gradient(to_right,_#eee,_#aaa)]', '.bg-\[linear-gradient\(to_right\2c _\#eee\2c _\#aaa\)\]{background-image:linear-gradient(to right, #eee, #aaa);}'],
            ['bg-[radial-gradient(ellipse_at_center,_#eee_0%,_#aaa_100%)]', '.bg-\[radial-gradient\(ellipse_at_center\2c _\#eee_0\%\2c _\#aaa_100\%\)\]{background-image:radial-gradient(ellipse at center, #eee 0%, #aaa 100%);}'],
            ['bg-[repeating-linear-gradient(45deg,_#eee,_#999_10px)]', '.bg-\[repeating-linear-gradient\(45deg\2c _\#eee\2c _\#999_10px\)\]{background-image:repeating-linear-gradient(45deg, #eee, #999 10px);}'],
            ['bg-[repeating-radial-gradient(circle_at_center,_#eee,_#999_10px)]', '.bg-\[repeating-radial-gradient\(circle_at_center\2c _\#eee\2c _\#999_10px\)\]{background-image:repeating-radial-gradient(circle at center, #eee, #999 10px);}'],
            ['bg-[conic-gradient(from_45deg,_#eee,_#999)]', '.bg-\[conic-gradient\(from_45deg\2c _\#eee\2c _\#999\)\]{background-image:conic-gradient(from 45deg, #eee, #999);}'],

            // Edge cases
            // ['bg-[url("https://example.com/image.jpg")]', '.bg-\[url\(\"https://example\.com/image\.jpg\"\)\]{background-image:url("https://example.com/image.jpg");}'],
            // ['bg-[linear-gradient(to_right,rgb(255,0,0),rgb(0,0,255))]', '.bg-\[linear-gradient\(to_right\2c rgb\(255\2c 0\2c 0\)\2c rgb\(0\2c 0\2c 255\)\)\]{background-image:linear-gradient(to right,rgb(255,0,0),rgb(0,0,255));}'],
            // ['bg-[url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAACklEQVR4nGMAAQAABQABDQottAAAAABJRU5ErkJggg==)]', '.bg-\[url\(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAACklEQVR4nGMAAQAABQABDQottAAAAABJRU5ErkJggg==\)\]{background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAACklEQVR4nGMAAQAABQABDQottAAAAABJRU5ErkJggg==);}'],
        ];
    }

    public function test_invalid_background_image_class(): void
    {
        $this->assertNull(BackgroundImageClass::parse('invalid-class'));
    }

    // #[DataProvider('invalidBackgroundImageProvider')]
    // public function testInvalidBackgroundImage(string $input): void
    // {
    //     $bgImageClass = BackgroundImageClass::parse($input);
    //     $this->assertInstanceOf(BackgroundImageClass::class, $bgImageClass);
    //     $this->assertSame('', $bgImageClass->toCss());
    // }

    // public static function invalidBackgroundImageProvider(): array
    // {
    //     return [
    //         ['bg-invalid'],
    //         ['bg-123'],
    //         ['bg-partial'],
    //         ['bg-[invalid]'],
    //         ['bg-[url]'],
    //         ['bg-[linear-gradient]'],
    //         ['bg-[radial-gradient]'],
    //         ['bg-[repeating-linear-gradient]'],
    //         ['bg-[repeating-radial-gradient]'],
    //         ['bg-[conic-gradient]'],
    //     ];
    // }

    #[DataProvider('escapedArbitraryValueProvider')]
    public function test_escaped_arbitrary_value(string $input, string $expected): void
    {
        $bgImageClass = BackgroundImageClass::parse($input);
        $this->assertInstanceOf(BackgroundImageClass::class, $bgImageClass);
        $this->assertSame($expected, $bgImageClass->toCss());
    }

    public static function escapedArbitraryValueProvider(): array
    {
        return [
            ['bg-[url(/path/to/image.jpg)]', '.bg-\[url\(/path/to/image\.jpg\)\]{background-image:url(/path/to/image.jpg);}'],
            ['bg-[linear-gradient(45deg,#ff0000,#00ff00)]', '.bg-\[linear-gradient\(45deg\2c \#ff0000\2c \#00ff00\)\]{background-image:linear-gradient(45deg,#ff0000,#00ff00);}'],
            ['bg-[radial-gradient(circle,#ff0000,#00ff00)]', '.bg-\[radial-gradient\(circle\2c \#ff0000\2c \#00ff00\)\]{background-image:radial-gradient(circle,#ff0000,#00ff00);}'],
            ['bg-[repeating-linear-gradient(45deg,#ff0000,#00ff00_10px)]', '.bg-\[repeating-linear-gradient\(45deg\2c \#ff0000\2c \#00ff00_10px\)\]{background-image:repeating-linear-gradient(45deg,#ff0000,#00ff00 10px);}'],
            ['bg-[conic-gradient(from_45deg,#ff0000,#00ff00)]', '.bg-\[conic-gradient\(from_45deg\2c \#ff0000\2c \#00ff00\)\]{background-image:conic-gradient(from 45deg,#ff0000,#00ff00);}'],
        ];
    }
}
