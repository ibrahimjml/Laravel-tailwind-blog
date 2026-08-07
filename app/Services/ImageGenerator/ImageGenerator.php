<?php

namespace App\Services\ImageGenerator;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Geometry\Factories\CircleFactory;
use Intervention\Image\Geometry\Factories\LineFactory;
use Intervention\Image\Geometry\Factories\RectangleFactory;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Typography\FontFactory;

class ImageGenerator
{
  protected ImageManager $manager;

  protected string $fontBold;

  protected string $fontRegular;

  protected string $fontSemiBold;

  public function __construct()
  {
    $this->manager = new ImageManager(new Driver);
    $this->fontBold = resource_path('fonts/IBM-Bold.ttf');
    $this->fontRegular = resource_path('fonts/Rubik-Regular.ttf');
    $this->fontSemiBold = resource_path('fonts/Poppins-SemiBold.ttf');
  }

  public function forHandlePostUpload(string $title): string
  {
    $width = 1200;
    $height = 630;

    $image = $this->manager->create($width, $height)->fill('000000');

    // Background Grid
    $this->drawBackgroundGrid($image, $width, $height);

    $this->drawCircles($image);

    $this->drawLeftAccent($image, $color = 'B91C1C');

    $this->drawBottomAccent($image, $width, $height, $color = 'B91C1C');

    $this->titleStyle(
      $image,
      $title,
      $color = 'FFFFFF'
    );

    $this->drawLogo(
      $image,
      $forM = 80,
      $forRest = 110,
      $color = 'FFFFFF',
      $this->fontBold
    );

    $this->drawWebsiteIcon($image);

    $this->drawCodeIcon($image);

    return $image->toPng()->toString();
  }
  public function forHandleOgImage(?Post $post): string
  {
    $width = 1200;
    $height = 630;

    $image = $this->manager->create($width, $height)->fill('ffffff');

    $this->drawBottomAccent($image, $width, $height, $color = '30AFFF');
    $this->drawLeftAccent($image, $color = '000000');

    $this->titleStyle(
      $image,
      $post->title,
      $color = '18181B'
    );

    $this->drawAuthorFooter(
      $image,
      $post->user->avatar_url,
      $post->user->name,
      $width
    );

    $this->drawLogo(
      $image,
      $forM = 965,
      $forRest = 1000,
      $color = '000000',
      $this->fontSemiBold
    );

    return $image->toPng()->toString();
  }

  private function drawAuthorFooter(ImageInterface $image, string $avatar, string $name, int $width): void
  {
    try {

      $avatarPath = Storage::disk(media_driver())->get('avatars/' . basename($avatar));

      $avatarImage = $this->manager->read($avatarPath)->cover(70, 70);

      $image->place($avatarImage, 'top-left', 85, 520);

    } catch (\Throwable $e) {
      logger()->error('OG avatar failed', [
        'error' => $e->getMessage()
      ]);
    }


    $image->text($name, 170, 550, function (FontFactory $font) {
      $font->filename($this->fontSemiBold);
      $font->size(26);
      $font->color('18181B');
      $font->align('left');
      $font->valign('middle');
    });
  }
  private function drawCircles(ImageInterface $image): void
  {
    $image->drawCircle(1120, 90, function (CircleFactory $circle) {
      $circle->radius(80);
      $circle->background('120000');
    });

    $image->drawCircle(120, 520, function (CircleFactory $circle) {
      $circle->radius(45);
      $circle->background('1A0000');
    });
  }
  private function drawLogo(ImageInterface $image, int $forM, int $forRest, string $color, string $fontPath): void
  {
    $image->text('M', $forM, 560, function (FontFactory $font) use ($fontPath) {
      $font->filename($fontPath);
      $font->size(38);
      $font->color('B91C1C');
    });

    $image->text('yBlog4U', $forRest, 560, function (FontFactory $font) use ($color, $fontPath) {
      $font->filename($fontPath);
      $font->size(38);
      $font->color($color);
    });
  }
  private function drawBackgroundGrid(ImageInterface $image, $width, $height): void
  {
    for ($x = 0; $x < $width; $x += 90) {
      $image->drawLine(function (LineFactory $line) use ($x, $height) {
        $line->from($x, 0);
        $line->to($x, $height);
        $line->color('2B0000');
        $line->width(1);
      });
    }

    for ($y = 0; $y < $height; $y += 90) {
      $image->drawLine(function (LineFactory $line) use ($y, $width) {
        $line->from(0, $y);
        $line->to($width, $y);
        $line->color('2B0000');
        $line->width(1);
      });
    }
  }
  private function drawLeftAccent(ImageInterface $image, string $color): void
  {
    $image->drawRectangle(90, 120, function (RectangleFactory $rect) use ($color) {
      $rect->size(6, 260);
      $rect->background($color);
    });
  }
  private function drawBottomAccent(ImageInterface $image, $width, $height, string $color): void
  {
    $accentHeight = 12;

    $image->drawRectangle(0, $height - $accentHeight, function (RectangleFactory $rect) use ($width, $accentHeight, $color) {
      $rect->size($width, $accentHeight);
      $rect->background($color);
    });
  }
  private function titleStyle(ImageInterface $image, ?string $title, string $color): void
  {
    $title = $title ?: 'MyBlog4U - Share Your Thoughts, Inspire the World';
    $lines = $this->wordWrap($title, 28);

    $y = 185;

    foreach ($lines as $line) {

      // Shadow
      $image->text($line, 302, $y + 2, function (FontFactory $font) {
        $font->filename($this->fontSemiBold);
        $font->size(58);
        $font->color('260000');
      });

      // Main title
      $image->text($line, 300, $y, function (FontFactory $font) use ($color) {
        $font->filename($this->fontSemiBold);
        $font->size(58);
        $font->color($color);
      });

      $y += 70;
    }
  }
  private function drawWebsiteIcon(ImageInterface $image): void
  {
    $image->text('myblog4u.site', 85, 598, function (FontFactory $font) {
      $font->filename($this->fontRegular);
      $font->size(18);
      $font->color('737373');
    });
  }
  private function drawCodeIcon(ImageInterface $image): void
  {
    $image->text('</>', 1060, 560, function (FontFactory $font) {
      $font->filename($this->fontBold);
      $font->size(34);
      $font->color('A1A1AA');
    });
  }
  private function wordWrap(string $text, int $maxChars): array
  {
    $words = explode(' ', $text);
    $lines = [];
    $current = '';

    foreach ($words as $word) {
      if (strlen($current . ' ' . $word) > $maxChars && $current !== '') {
        $lines[] = trim($current);
        $current = $word;
      } else {
        $current .= ($current ? ' ' : '') . $word;
      }
    }
    if ($current) {
      $lines[] = trim($current);
    }

    return array_slice($lines, 0, 4);
  }
}