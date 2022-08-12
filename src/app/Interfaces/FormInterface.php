<?php


namespace App\Interfaces;

/**
 * Interface AgentRepositoryInterface
 * @package App\Interfaces
 */
interface FormInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function createForm(array $data);

    /**
     * @param int $id
     * @return mixed
     */
    public function getForm(int $id);

    /**
     * @param array $data
     * @return mixed
     */
    public function saveForm(array $data);

}
