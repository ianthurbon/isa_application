<?php

namespace App\Infrastructure\Persistence\AccountTransactions;

use App\Domain\AccountTransactions\DTO\AccountTransactionData;
use App\Domain\AccountTransactions\AccountTransactionRepository;


class SQLAccountTransactionRepository extends AccountTransactionRepository
{

    /**
     * Creates a new transaction.
     *
     * @param AccountTransactionData $request The data for the transaction to be created.
     * @return AccountTransactionData The created transaction data.
     */
    public function create(AccountTransactionData $request): AccountTransactionData
    {
        $transaction = AccountTransaction::create($request->toArray());
        $transaction->save();

        return new AccountTransactionData($transaction->toArray());
    }

    /**
     * Retrieves all transactions, optionally filtered by account ID.
     *
     * @param int|null $accountId The ID of the account to filter transactions by, or null to retrieve all transactions.
     * @return array An array of AccountTransactionData objects representing the transactions.
     */
    public function findAll(?int $accountId): array
    {
        $transactions      = [];
        if($accountId){
            $models = AccountTransaction::where([
                ['account','=',$accountId]
            ])->get();
        } else {
            $models = AccountTransaction::all();
        }

        foreach ($models as $model) {
            $transactions[] = new AccountTransactionData($model->toArray());
        }

        return $transactions;
    }

    /**
     * Calculates the total deposits for the current tax year starting from the previous April 1st.
     *
     * @param int $accountId The ID of the account for which to calculate the deposits.
     * @return float The total amount of deposits in GBP for the current tax year.
     * @throws \Exception
     */
    public function currentTaxYearDeposits(int $accountId): float
    {
        return AccountTransaction::where([
            ['created_at', '>=', $this->getPreviousAprilFirst()],
            ['transaction_type', '=', AccountTransactionData::DEPOSIT_TRANSACTION],
            ['account', '=', $accountId]
        ])->sum("gbp_total");
    }

    /**
     * Returns a date string in 'Y-m-d' format for the previous April 1st.
     * This function was created by ChatGPT4o
     *
     * @return string The date string for the previous April 1st.
     * @throws \Exception
     */
    protected function getPreviousAprilFirst(): string
    {
        $currentDate = new \DateTime();
        $currentYear = (int)$currentDate->format('Y');
        $currentMonth = (int)$currentDate->format('m');

        // If the current month is before April, return April 1st of the previous year
        if ($currentMonth < 4) {
            $previousAprilFirst = new \DateTime(($currentYear - 1) . '-04-01');
        } else {
            $previousAprilFirst = new \DateTime($currentYear . '-04-01');
        }

        return $previousAprilFirst->format('Y-m-d');
    }
}