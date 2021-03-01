<?php

namespace App\UserInterface\Controller;

use App\UserInterface\DataTRansferObject\RegistrationDTO;
use App\UserInterface\Form\RegistrationType;
use App\UserInterface\Presenter\RegistrationPresenter;
use Domain\Security\Request\RegistrationRequest;
use Domain\Security\UseCase\Registration;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class RegistrationController
{
    private FormFactoryInterface $formFactory;
    private Environment $twig;
    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $urlGenerator;
    /**
     * @var FlashBagInterface
     */
    private FlashBagInterface $flashBag;

    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $twig,
        UrlGeneratorInterface $urlGenerator,
        FlashBagInterface $flashBag
    ) {
        $this->formFactory  = $formFactory;
        $this->twig         = $twig;
        $this->urlGenerator = $urlGenerator;
        $this->flashBag     = $flashBag;
    }


    /**
     * @param Request      $request
     * @param Registration $registration
     *
     */
    #[Route(path: "/registration", name: "app.registration")]
    public function __invoke(
        Request $request,
        Registration $registration
    ): RedirectResponse | Response {


        $form = $this->formFactory->create(RegistrationType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var RegistrationDTO $registrationData */
            $registrationData      = $form->getData();

            $registrationRequest   = RegistrationRequest::create(
                $registrationData->getPseudo(),
                $registrationData->getFirstname(),
                $registrationData->getLastname(),
                $registrationData->getEmail(),
                $registrationData->getPlainPassword(),
            );

            $registrationPresenter = new RegistrationPresenter();
            $registration->execute($registrationRequest, $registrationPresenter);

            $this->flashBag->add(
                'success',
                'Welcome in site.'
            );

            return new RedirectResponse($this->urlGenerator->generate("home"));
        }

        return new Response(
            $this->twig->render(
                'ui/registration.html.twig',
                [
                    'form' => $form->createView(),
                ]
            )
        );
    }
}
