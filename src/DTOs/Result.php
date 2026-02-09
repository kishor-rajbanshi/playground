<?php

namespace KishorRajbanshi\Sms\DTOs;

/**
 * Data transfer object for SMS results.
 */
class Result
{
    /**
     * Create a new Result instance.
     *
     * @param  bool  $success  Whether the SMS was sent successfully
     * @param  string|null  $uid  Optional unique identifier from the provider
     * @param  string|null  $error  Optional error message if sending failed
     * @param  string|null  $provider  Optional name of the SMS provider used
     * @param  mixed  $raw  Optional raw response data from the provider
     */
    final public function __construct(
        public bool $success,
        public ?string $uid = null,
        public ?string $error = null,
        public ?string $provider = null,
        public mixed $raw = null,
    ) {}

    /**
     * Create a new Result instance from given parameters.
     *
     * @param  bool  $success  Whether the SMS was sent successfully
     * @param  string|null  $uid  Optional unique identifier from the provider
     * @param  string|null  $error  Optional error message if sending failed
     * @param  string|null  $provider  Optional name of the SMS provider used
     * @param  mixed  $raw  Optional raw response data from the provider
     */
    public static function make(
        bool $success,
        ?string $uid = null,
        ?string $error = null,
        ?string $provider = null,
        mixed $raw = null
    ): static {
        return new static($success, $uid, $error, $provider, $raw);
    }
}
