<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Command;

use PragmaGoTech\Interview\Factory\LoanProposalFactory;
use PragmaGoTech\Interview\Service\FeeCalculatorHelperInterface;
use PragmaGoTech\Interview\Service\InputTransformerInterface;
use PragmaGoTech\Interview\Strategy\LoanStrategy;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'app:loan-fee-calculator',
    description: 'Calculate loan fee',
    hidden: false,
)]
class LoanCalculatorCommand extends Command
{
    public function __construct(
        private readonly InputTransformerInterface $transformer,
        private readonly FeeCalculatorHelperInterface $feeHelper,
        private readonly LoanStrategy $loanStrategy
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();
        $this->setDescription('Allows calculate loan fee for given amount and term');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');
        $amountQuestion = $this->prepareAmountQuestion();
        $termQuestion = new ChoiceQuestion(
            'Please select term of loan (in months)',
                     [12,24],
            0
        );

        $amount = (float) $helper->ask($input, $output, $amountQuestion);
        $termMonths = $helper->ask($input, $output, $termQuestion);
        $loanProposal = LoanProposalFactory::create($termMonths, $amount);
        $fee = $this->loanStrategy->calculate($loanProposal);

        $roundedUpFee = $this->feeHelper->roundUpLoanAndFeeSum($fee,$amount);
        $output->writeln("Your fee is " . $roundedUpFee);

        return self::SUCCESS;
    }

    private function prepareAmountQuestion(): Question
    {
        $amountQuestion = new Question(
            "Please provide the amount of the loan. Loan need to be\n- in range 1000 to 20000\n- contains up to 2 decimal places(anything above will be cut (not rounded))\n:",
            5000);
        $amountQuestion->setValidator(function ($answer) {
            $amount = (float) $this->transformer->truncateToDecimal($answer);
            if ($amount < 1000 || $amount > 20000) {
                throw new RuntimeException('The amount must be between 1000 and 20000.');
            }

            return $amount;
        });
        $amountQuestion->setMaxAttempts(null);

        return $amountQuestion;
    }
}
