<?php

namespace App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DataUriNormalizer;
use Symfony\Component\Serializer\Normalizer\DateIntervalNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

final class SerializerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerTaggedService(
            'serializer.encoder.json',
            JsonEncoder::class,
            null,
            ['serializer.encoder']
        );

        $this->registerTaggedService(
            'serializer.normalizer.json_serializable',
            JsonSerializableNormalizer::class,
            null,
            ['serializer.normalizer']
        );

        $this->registerTaggedService(
            'serializer.normalizer.dateinterval',
            DateIntervalNormalizer::class,
            null,
            ['serializer.normalizer']
        );

        $this->registerTaggedService(
            'serializer.normalizer.data_uri',
            DataUriNormalizer::class,
            null,
            ['serializer.normalizer']
        );

        $this->registerTaggedService(
            'serializer.normalizer.date_time',
            DateTimeNormalizer::class,
            null,
            ['serializer.normalizer']
        );

        $this->registerTaggedService(
            'serializer.normalizer.object',
            ObjectNormalizer::class,
            null,
            ['serializer.normalizer']
        );

        $this->registerTaggedService(
            'serializer',
            Serializer::class,
            static function (Application $app) {
                $normalizers = [];
                foreach ($app->tagged('serializer.normalizer') as $normalizer) {
                    $normalizers[] = $normalizer;
                }

                $encoders = [];
                foreach ($app->tagged('serializer.encoder') as $encoder) {
                    $encoders[] = $encoder;
                }

                return new Serializer($normalizers, $encoders);
            }
        );

        $this->app->bind(NormalizerInterface::class, 'serializer');
        $this->app->bind(DenormalizerInterface::class, 'serializer');
        $this->app->bind(EncoderInterface::class, 'serializer');
        $this->app->bind(DecoderInterface::class, 'serializer');
        $this->app->bind(SerializerInterface::class, 'serializer');
    }

    private function registerTaggedService($id, $class, callable $constructor = null, array $tags = [])
    {
        if (null === $constructor) {
            $constructor = function () use ($class) {
                return new $class();
            };
        }

        $this->app->singleton($id, $constructor);
        $this->app->bind($class, $id);
        foreach ($tags as $tag) {
            $this->app->tag($id, $tag);
        }
    }
}
