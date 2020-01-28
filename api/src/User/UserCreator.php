<?php


namespace App\User;

use App\Interfaces\IEntity;
use App\Interfaces\IUserRepo;
use App\RequestBody\JsonToArray;
use App\Exception\JsonToArrayException;
use App\Exception\UserValidatorException;
use App\Exception\UserCreatorException;

class UserCreator
{
    private $converter;
    private $repo;
    private $validator;

    public function __construct(JsonToArray $converter, IUserRepo $repo, UserValidator $validator)
    {
        $this->converter = $converter;
        $this->repo = $repo;
        $this->validator = $validator;
    }

    public function handle(): IEntity
    {
        try {
            $requestBody = $this->converter->retrieve();
            $this->validator->validate($requestBody);
            $newUser = $this->repo->create($requestBody);
        } catch (JsonToArrayException $e) {
            throw new UserCreatorException($e->getErrors());
        } catch (UserValidatorException $e) {
            throw new UserCreatorException($e->getErrors());
        }
        return $newUser;
    }
}