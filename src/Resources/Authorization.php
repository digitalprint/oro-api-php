<?php

namespace Digitalprint\Oro\Api\Resources;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use JsonException;

class Authorization extends BaseResource
{
    /**
     * @var string
     */
    public string $resource;

    /**
     * Either "live" or "test". Indicates this being a test or a live (verified) job.
     *
     * @var string
     */
    public string $mode;

    /**
     * @var string
     */
    public string $access_token;

    /**
     * @param array $options
     * @return $this
     * @throws ApiException
     * @throws JsonException
     */
    public function create(array $options = []): self
    {
        return $this->client->authorization->create($this->withPresetOptions($options));
    }

    /**
     * When accessed by oAuth we want to pass the testmode by default
     *
     * @return array
     */
    private function getPresetOptions(): array
    {
        $options = [];
        if ($this->client->usesOAuth()) {
            $options["testmode"] = $this->mode === "test";
        }

        return $options;
    }

    /**
     * Apply the preset options.
     *
     * @param array $options
     * @return array
     */
    private function withPresetOptions(array $options): array
    {
        return array_merge($this->getPresetOptions(), $options);
    }
}
