<?php
/**
 * Created by PhpStorm.
 * User: taras
 * Date: 15.01.19
 * Time: 1:45
 */

namespace App\Twig;


use App\Entity\LikeNotification;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension implements GlobalsInterface
{
    /**
     * @var string
     */
    private $locale;

    public function __construct(string $locale)
    {
        $this->locale = $locale;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('price', [$this, 'priceFilter'])
        ];
    }

    public function getGlobals()
    {
        return [
            'locale' => $this->locale
        ];
    }

    public function priceFilter($number)
    {
        return '$'.number_format($number, 2, '.', ',');
    }

    public function getTests()
    {
        return [
            new \Twig_SimpleTest(
                'like',
                function ($obj) { return $obj instanceof LikeNotification;}
            )
        ];
    }
}