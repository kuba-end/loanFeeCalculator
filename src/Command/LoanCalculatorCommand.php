<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Command;

use PragmaGoTech\Interview\Enum\FeeEnum;
use PragmaGoTech\Interview\Factory\LoanProposalFactory;
use PragmaGoTech\Interview\Factory\LoanStrategyFactoryInterface;
use PragmaGoTech\Interview\Service\CalculatorInterface;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperInterface;
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
        private readonly CalculatorInterface $calculator,
        private readonly LoanStrategyFactoryInterface $loanStrategyFactory
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
        $helper = $this->getHelper('question');
        $amountQuestion = $this->prepareAmountQuestion($helper, $input, $output);
        $termQuestion = new ChoiceQuestion(
            'Please select term of loan (in months)',
                     [12,24],
            0
        );

        $amount = (float) $helper->ask($input, $output, $amountQuestion);
        $termMonths = $helper->ask($input, $output, $termQuestion);

        $term = FeeEnum::from($termMonths);
        $loanStrategy = $this->loanStrategyFactory->create($term);
        $loanProposal = LoanProposalFactory::create($termMonths, $amount);

        $fee = $loanStrategy->calculate($loanProposal);
        $roundedUpFee = $this->calculator->roundUpLoanAndFeeSum($fee,$amount);
        $output->writeln("Your fee is " . $roundedUpFee);

        return self::SUCCESS;
    }

    private function prepareAmountQuestion(HelperInterface $helper, InputInterface $input, OutputInterface $output): Question
    {
        $amountQuestion = new Question('Please provide the amount of the loan (minimum loan is 1000 and maximum is 20000): ', 5000);
        $amountQuestion->setValidator(function ($answer) {
            $amount = (float) $this->calculator->truncateToDecimal($answer);
            if ($amount < 1000 || $amount > 20000) {
                throw new RuntimeException('The amount must be between 1000 and 20000.');
            }

            return $amount;
        });
        $amountQuestion->setMaxAttempts(null);

        return $amountQuestion;
    }
}
