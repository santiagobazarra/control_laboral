<?php

namespace App\Services;

class TenantService
{
    protected ?Company $currentCompany = null;

    /**
     * Set the current active company.
     */
    public function setCompany(?Company $company): void
    {
        $this->currentCompany = $company;
    }

    /**
     * Get the current active company.
     */
    public function getCompany(): ?Company
    {
        return $this->currentCompany;
    }

    /**
     * Get the ID of the current active company.
     */
    public function getCompanyId(): ?int
    {
        return $this->currentCompany?->id;
    }

    /**
     * Check if a company context is currently set.
     */
    public function isCompanySet(): bool
    {
        return $this->currentCompany !== null;
    }
}
