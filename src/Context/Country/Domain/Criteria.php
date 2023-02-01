<?php

declare(strict_types=1);

namespace App\Context\Country\Domain;

class Criteria
{
    public bool $result;
    public array $criteria;

    public function __construct(protected Country $country, protected Country $rival)
    {
        $this->criteria = [
            'name' => $this->hasValidName(),
            'region' => $this->hasValidRegion(),
            'population' => $this->hasValidPopulation(),
            'rival' => $this->hasMorePopupationThanRival()
        ];

        $this->result = $this->hasValidResult();
    }

    /**********************
     * Verify that all criterias are meet
     * @return bool
     */
    private function hasValidResult(): bool
    {
        return
            $this->criteria['name'] &&
            $this->criteria['region'] &&
            $this->criteria['population'] &&
            $this->criteria['rival'];
    }

    /**********************
     * Verify that name is contains only alpha chars
     * @return bool
     */
    private function hasValidName(): bool
    {

        return !!preg_match('/^[aeiou]/i', strtolower($this->country->name()->value()));
    }

    /**********************
     * Verify that region is Europe
     * @return bool
     */
    private function hasValidRegion(): bool
    {
        return strtolower($this->country->region()->value()) === 'europe';
    }

    /**********************
     * Verify that population counts are correct
     * @return bool
     */
    private function hasValidPopulation(): bool
    {
        return (
            strtolower($this->country->region()->value()) === 'asia' &&
            $this->country->population()->value() >= 80000000
        ) || $this->country->population()->value() >= 50000000;
    }

    /**********************
     * Verify that population is greater than rival
     * @return bool
     */
    private function hasMorePopupationThanRival(): bool
    {
        return  $this->country->population()->value() > $this->rival->population()->value();
    }
}