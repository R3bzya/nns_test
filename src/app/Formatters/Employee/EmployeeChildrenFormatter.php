<?php

namespace App\Formatters\Employee;

use App\Models\Employee\Employee;
use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\Collection;

class EmployeeChildrenFormatter
{
    public function children(Employee $employee): Dompdf
    {
        return $this->pdf($this->tableString($employee, $employee->children));
    }

    public function descendants(Employee $employee): Dompdf
    {
        return $this->pdf($this->tableString($employee, $employee->descendants));
    }

    private function tableString(Employee $employee, Collection $collection): string
    {
        return "<table>
            <tr>
                <td>name: {$employee->name}</td>
            </tr>
            <tr>
                <td>employees: {$this->getStringEmployees($collection)}</td>
            </tr>
        </table>";
    }

    /**
     * @param Employee[]|Collection $collection
     * @return string
     */
    private function getStringEmployees(Collection $collection): string
    {
        $names = [];
        foreach ($collection as $employee) {
            $names[] = $employee->name;
        }
        return implode(', ', $names);
    }

    private function pdf(string $tableString): Dompdf
    {
        $pdf = new Dompdf();
        $pdf->loadHtml($tableString);
        $pdf->render();
        return $pdf;
    }
}
