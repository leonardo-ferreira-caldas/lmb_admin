<?php

namespace App\Helpers\Validation;

trait Validation {

    /**
     * Validate if the delete can be done
     *
     * @return \Illuminate\Support\Collection
     */
    protected function validateDelete($data) {

        if (method_exists($this, 'beforeDelete')) {

            try {
                $this->beforeDelete($data);

                return true;
            } catch (\Exception $e) {

                return $e->getMessage();

            }

        }

    }

}