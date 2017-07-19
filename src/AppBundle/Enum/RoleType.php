<?php

namespace AppBundle\Enum;


class RoleType
{
    /** @var string */
    private $type;

    /**
     * @var array
     */
    private static $supported = [
        'actor' => 'Actor',
        'director' => 'Director',
        'writer' => 'Writer',
        'producer' => 'Producer',
        'executive_producer' => 'Executive producer',
        'production_manager' => 'Production manager',
        'casting_director' => 'Casting director',
        'art_director' => 'Art director',
        'costume_designer' => 'Costume designer',
    ];

    /**
     * @param string $type
     *
     * @throws \InvalidArgumentException
     */
    private function __construct($type)
    {
        if (!in_array($type, self::$supported)) {
            throw new \InvalidArgumentException('Role '.$type.' not supported.');
        }
        $this->type = $type;
    }

    /**
     * @param string $type
     *
     * @return self
     */
    public static function createFromString($type)
    {
        return new self($type);
    }

    /**
     * @return array
     */
    public static function getAll()
    {
        return self::$supported;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->type;
    }
}