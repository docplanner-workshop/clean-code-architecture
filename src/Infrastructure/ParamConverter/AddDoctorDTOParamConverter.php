<?php
declare(strict_types=1);

namespace App\Infrastructure\ParamConverter;

use App\Action\Input\AddDoctorDTO;
use App\Infrastructure\RequestValidator\RequestValidator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

final class AddDoctorDTOParamConverter implements ParamConverterInterface
{
    private RequestValidator $requestValidator;

    public function __construct(RequestValidator $requestValidator)
    {
        $this->requestValidator = $requestValidator;
    }

    public function apply(Request $request, ParamConverter $configuration): void
    {
        $addDoctorDTO = new AddDoctorDTO(
            (string)$request->request->get('firstName'),
            (string)$request->request->get('lastName'),
            (string)$request->request->get('specialization')
        );

        $this->requestValidator->validate($addDoctorDTO);

        $request->attributes->set($configuration->getName(), $addDoctorDTO);
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() === AddDoctorDTO::class;
    }
}
