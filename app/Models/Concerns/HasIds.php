<?php

namespace App\Models\Concerns;

use Illuminate\Support\Collection;

/**
 * Trait HasIds
 * 
 * Provides functionality for models that need to work with multiple identifiers
 * or composite keys.
 */
trait HasIds
{
    /**
     * The array of IDs for the model.
     *
     * @var array
     */
    protected array $ids = [];
    
    /**
     * Set the model's IDs.
     *
     * @param  array  $ids
     * @return $this
     */
    public function setIds(array $ids): static
    {
        $this->ids = $ids;
        
        return $this;
    }
    
    /**
     * Get the model's IDs.
     *
     * @return array
     */
    public function getIds(): array
    {
        return $this->ids;
    }

    /**
     * Get the model's IDs as a collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getIdsCollection(): Collection
    {
        return collect($this->ids);
    }
    
    /**
     * Add an ID to the model's IDs collection.
     *
     * @param  mixed  $id
     * @param  string|null  $key
     * @return $this
     */
    public function addId(mixed $id, ?string $key = null): static
    {
        if ($key !== null) {
            $this->ids[$key] = $id;
        } else {
            $this->ids[] = $id;
        }
        
        return $this;
    }
    
    /**
     * Check if the model has a specific ID.
     *
     * @param  mixed  $id
     * @param  string|null  $key
     * @return bool
     */
    public function hasId(mixed $id, ?string $key = null): bool
    {
        if ($key !== null) {
            return isset($this->ids[$key]) && $this->ids[$key] === $id;
        }
        
        return in_array($id, $this->ids, true);
    }
    
    /**
     * Remove an ID from the model's IDs collection.
     *
     * @param  mixed  $id
     * @param  string|null  $key
     * @return $this
     */
    public function removeId(mixed $id, ?string $key = null): static
    {
        if ($key !== null) {
            if (isset($this->ids[$key]) && $this->ids[$key] === $id) {
                unset($this->ids[$key]);
            }
        } else {
            $this->ids = array_values(array_filter($this->ids, fn($existingId) => $existingId !== $id));
        }
        
        return $this;
    }

    /**
     * Clear all IDs from the model.
     *
     * @return $this
     */
    public function clearIds(): static
    {
        $this->ids = [];
        
        return $this;
    }
} 