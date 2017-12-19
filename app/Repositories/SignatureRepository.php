<?php 

namespace App\Repositories;

use App\Signature;
use ActivismeBE\DatabaseLayering\Repositories\Eloquent\Repository;

/**
 * Class SignatureRepository
 *
 * @package App\Repositories
 */
class SignatureRepository extends Repository
{
    /**
     * Set the eloquent model class for the repository.
     *
     * @return string
     */
    public function model()
    {
        return Signature::class;
    }

    /**
     * Slaag een handtekening op in het systeem.
     *
     * @param  array $input De gegeven invoer van de gebruiker. (Validatie -> controller)
     * @return Signature
     */
    public function createSignature(array $input): Signature
    {
        return $this->create($input);
    }
}