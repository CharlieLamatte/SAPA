<?php

require 'fpdf.php';

class PDF extends FPDF
{
    var int $cellspacing = 0;
    var bool $is_footer_displayed = false;
    var array $widths;

    /**
     * Sets the spacing between RoundedBorderCells
     *
     * @param $cellspacing int
     */
    function SetCellspacing($cellspacing)
    {
        $this->cellspacing = $cellspacing;
    }

    /**
     * Sets if the footer is displayed
     *
     * @param $is_footer_displayed boolean
     */
    function SetIsFooterDisplayed($is_footer_displayed)
    {
        $this->is_footer_displayed = $is_footer_displayed;
    }

    /**
     * Sets the array of column widths
     *
     * @param $w
     */
    function SetEvalRowWidths($w)
    {
        $this->widths = $w;
    }

    // Page footer
    function Footer()
    {
        if ($this->is_footer_displayed) {
            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Helvetica', 'I', 8);
            $this->SetTextColor(150, 150, 150);
            // Page number
            $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }
    }

    /**
     * Displays the name of an evaluation
     *
     * @param string $txt the name of the evaluation
     * @param string $drawColor
     */
    function EvalTitle($txt, $drawColor = "rose")
    {
        $txt = utf8_decode($txt);
        $margins = $this->lMargin + $this->rMargin;

        //Calculate the height of the row
        $h = 6 + 4 + 6;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        $current_x = $this->GetX();
        $current_y = $this->GetY();

        if ($drawColor == "rose") {
            $this->SetDrawColor(236, 0, 140);
        } elseif ($drawColor == "vert") {
            $this->SetDrawColor(76, 174, 76);
        } else {
            $this->SetDrawColor(236, 0, 140); // couleur par défaut
        }

        $this->Line($current_x + 1, $current_y, $current_x + $this->GetPageWidth() - $margins, $current_y);

        $this->SetTextColor(255, 255, 255);

        if ($drawColor == "rose") {
            $this->SetfillColor(236, 0, 140);
        } elseif ($drawColor == "vert") {
            $this->SetfillColor(76, 174, 76);
        } else {
            $this->SetDrawColor(236, 0, 140); // couleur par défaut
        }

        $this->SetFont('Helvetica', '', 13);

        $txt_size = $this->GetStringWidth($txt) + 2;
        $this->RoundedBorderCell($txt_size, 6, $txt, 0, "L", false, 0);
        $this->Cell($this->GetPageWidth() - $margins - $txt_size, 4, "", 'R', 0, "R", 0);

        $this->Ln();
        $this->Cell($this->GetPageWidth() - $margins, 6, "", 'LR', 0, "R", 0);
        $this->Ln();
    }

    /**
     * Displays an evaluation's row of size 3
     * | label1 value1 | label2 value2 | label3 value3 |
     *
     * @param array $data the array of labels and value. example: [label1, value1, label2, value2, label3, value3]
     * @param bool  $is_bottom_border if the bottom border is displayed
     */
    function EvalSize3Row($data, $is_bottom_border = false)
    {
        $margins = $this->lMargin + $this->rMargin;

        $this->SetFont('Helvetica', 'B', 10);

        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $data[$i] = utf8_decode($data[$i]);
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        $this->EvalLabelCell($this->widths[0], $h, $data[0], true);
        $this->EvalValueCell($this->widths[1], $h, $data[1]);

        $this->EvalLabelCell($this->widths[2], $h, $data[2]);
        $this->EvalValueCell($this->widths[3], $h, $data[3]);

        $this->EvalLabelCell($this->widths[2], $h, $data[4]);
        $this->EvalValueCell($this->widths[3], $h, $data[5], true);

        $this->Ln();

        $border = 'LR';
        $space = 2;
        if ($is_bottom_border) {
            $border = 'BLR';
            $space = 1;
        }
        $this->Cell($this->GetPageWidth() - $margins, $space, "", $border, 0, "R", 0);
        $this->Ln();
    }

    /**
     * Displays an evaluation's row of size 2
     * | label1 value1 | label2 value2 |
     *
     * @param array $data the array of labels and value. example: [label1, value1, label2, value2]
     * @param bool  $is_bottom_border if the bottom border is displayed
     */
    function EvalSize2Row($data, $is_bottom_border = false)
    {
        $margins = $this->lMargin + $this->rMargin;

        $this->SetFont('Helvetica', 'B', 10);

        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $data[$i] = utf8_decode($data[$i]);
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Draw the cells of the row
        $this->EvalLabelCell($this->widths[0], $h, $data[0], true);
        $this->EvalValueCell($this->widths[1], $h, $data[1]);

        $this->EvalLabelCell($this->widths[2], $h, $data[2]);
        $this->EvalValueCell($this->widths[3], $h, $data[3], true);

        $this->Ln();

        $border = 'LR';
        $space = 2;
        if ($is_bottom_border) {
            $border = 'BLR';
            $space = 1;
        }
        $this->Cell($this->GetPageWidth() - $margins, $space, "", $border, 0, "R", 0);
        $this->Ln();
    }

    /** Displays an evaluation's row of size 1
     * | label1 value1 |
     *
     * @param array $data the array of labels and value. example: [label1, value1]
     * @param bool  $is_bottom_border if the bottom border is displayed
     */
    function EvalSize1Row($data, $is_bottom_border = false)
    {
        $margins = $this->lMargin + $this->rMargin;

        $this->SetFont('Helvetica', 'B', 10);

        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $data[$i] = utf8_decode($data[$i]);
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Draw the cells of the row
        $this->EvalLabelCell($this->widths[0], $h, $data[0] ?? "", true);
        $this->EvalValueCell($this->widths[1], $h, $data[1] ?? "", true);

        $this->Ln();

        $border = 'LR';
        $space = 2;
        if ($is_bottom_border) {
            $border = 'BLR';
            $space = 1;
        }
        $this->Cell($this->GetPageWidth() - $margins, $space, "", $border, 0, "R", 0);
        $this->Ln();
    }

    /**
     * Displays a cell for an evaluation's label
     *
     * @param        $w
     * @param        $h
     * @param string $txt the text that will be displayed
     * @param bool   $is_left_border if the left border is displayed
     */
    function EvalLabelCell($w, $h, $txt, $is_left_border = false)
    {
        $this->SetFont('Helvetica', 'B', 10);
        $this->SetTextColor(1, 38, 120);

        //Save the current position
        $x = $this->GetX();
        $y = $this->GetY();

        //Draw the left border
        if ($is_left_border) {
            $this->SetDrawColor(236, 0, 140);
            $this->Line($x, $y, $x, $y + $h);
        }

        //Print the text
        $this->MultiCell($w, 5, $txt, 0, 'R');
        //Put the position to the right of the cell
        $this->SetXY($x + $w, $y);
    }

    /**
     * Displays a cell for an evaluation's value
     *
     * @param        $w
     * @param        $h
     * @param string $txt the text that will be displayed
     * @param bool   $is_right_border if the right border is displayed
     */
    function EvalValueCell($w, $h, $txt, $is_right_border = false)
    {
        $this->SetFont('Helvetica', '', 10);
        $this->SetTextColor(1, 38, 120);
        $this->SetFillColor(240);

        //Save the current position
        $x = $this->GetX();
        $y = $this->GetY();
        //Draw the background
        $this->RoundedRect($x, $y, $w, $h, 1, 'F');
        //Print the text
        $this->MultiCell($w, 5, $txt, 0, 'LC');
        //Put the position to the right of the cell
        $this->SetXY($x + $w, $y);

        //Draw the right border
        if ($is_right_border) {
            $this->Cell($this->GetPageWidth() - $this->GetX() - $this->rMargin, $h, "", 'R', 0, "R", 0);
        }
    }

    function Coordonnes($data)
    {
        if (count($data) <= 0) {
            return;
        }

        //Calculate the height of the row
        $nb = 0;
        foreach ($data as &$val) {
            $val = utf8_decode($val);
            $nb++;
        }
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        $w = $this->widths[0];

        //Print the text
        $last_key = array_key_last($data);
        $first_key = array_key_first($data);
        foreach ($data as $key => $value) {
            switch ($key) {
                case "nom":
                case "titre":
                    $link = "";
                    $this->SetFont('Helvetica', 'B', 10);
                    $this->SetTextColor(60, 60, 60);
                    break;
                case "email":
                    $link = "mailto:" . $value;
                    $this->SetFont('Helvetica', 'U', 10);
                    $this->SetTextColor(0, 0, 238);
                    break;
                default:
                    $link = "";
                    $this->SetFont('Helvetica', '', 10);
                    $this->SetTextColor(60, 60, 60);
                    break;
            }

            $border = "LR";
            if ($last_key == $key) {
                $border .= "B";
            }
            if ($first_key == $key) {
                $border .= "T";
            }

            $this->Cell($w, 5, $value, $border, 1, "", 0, $link);
        }
    }

    function DetailsPatient($data)
    {
        if (count($data) <= 0) {
            return;
        }

        $target_logo_width = 50;
        $logo_path = "../../../images/logo_INSi_mention.png";
        $logo_size = getimagesize($logo_path);
        //if ($logo_size) {
            $ratio = $logo_size[0] / $logo_size[1];
            $target_height =  $ratio / $target_logo_width;
        //}

        //Calculate the height of the row
        $nb = 0;
        foreach ($data as &$val) {
            $val = utf8_decode($val);
            $nb++;
        }
        $h = 5 * $nb + $target_height;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        $w = $this->widths[0];

        //Print the text

        $x = $this->GetX();
        $y = $this->GetY();
        $this->Cell($w, 25, "", "LRT", 1, "", 0, "");
        $this->Image($logo_path, $x, $y, $target_logo_width);

        $last_key = array_key_last($data);
        foreach ($data as $key => $value) {
            switch ($key) {
                case "nom":
                case "titre":
                    $link = "";
                    $this->SetFont('Helvetica', 'B', 10);
                    $this->SetTextColor(60, 60, 60);
                    break;
                case "email":
                    $link = "mailto:" . $value;
                    $this->SetFont('Helvetica', 'U', 10);
                    $this->SetTextColor(0, 0, 238);
                    break;
                default:
                    $link = "";
                    $this->SetFont('Helvetica', '', 10);
                    $this->SetTextColor(60, 60, 60);
                    break;
            }

            $border = "LR";
            if ($last_key == $key) {
                $border .= "B";
            }

            $this->Cell($w, 5, $value, $border, 1, "", 0, $link);
        }
    }

    /**
     * Adds a new page immediately if the height $h would cause an overflow
     *
     * @param $h
     */
    function CheckPageBreak($h)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }
    }

    /**
     * Computes the number of lines a MultiCell of width $w will take
     *
     * @param $w
     * @param $txt
     * @return int
     */
    function NbLines($w, $txt)
    {
        $cw =& $this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }

    function RoundedBorderCell($w, $h = 0, $txt = '', $border = 0, $align = '', $fill = false, $link = '', $style = 'F')
    {
        $this->RoundedRect(
            $this->getX() + $this->cellspacing / 2,
            $this->getY() + $this->cellspacing / 2,
            $w - $this->cellspacing,
            $h,
            1,
            $style
        );
        $this->Cell(
            $w,
            $h + $this->cellspacing,
            $txt,
            $border,
            0,
            $align,
            $fill,
            $link
        );
    }

    function RoundedRect($x, $y, $w, $h, $r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F') {
            $op = 'f';
        } elseif ($style == 'FD' || $style == 'DF') {
            $op = 'B';
        } else {
            $op = 'S';
        }
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));
        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));

        $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);
        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
        $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);
        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(
            sprintf(
                '%.2F %.2F %.2F %.2F %.2F %.2F c ',
                $x1 * $this->k,
                ($h - $y1) * $this->k,
                $x2 * $this->k,
                ($h - $y2) * $this->k,
                $x3 * $this->k,
                ($h - $y3) * $this->k
            )
        );
    }

    /**
     * Displays a table
     *
     * @param array $headers
     * @param array $data rows of data of the table
     * @param array $widths widths of the comlums of the table
     * @param bool  $is_bottom_border if the bottom border is displayed
     */
    function EvalTableRow($headers, $data, $widths, $is_bottom_border = false)
    {
        $col_num = count($headers);
        $this->SetFont('Helvetica', 'B', 10);
        $this->SetTextColor(1, 38, 120);

        $margins = $this->lMargin + $this->rMargin;

        // Header
        foreach ($headers as $i => $col) {
            // no border for first column
            $border = 1;
            if (empty($col)) {
                $border = 0;
            }

            // eval left border
            if ($i == 0) {
                $this->SetDrawColor(236, 0, 140);
                $this->Cell(4.5, 5, "", 'L', 0, "R", 0);
            }

            $this->SetDrawColor(1, 38, 120);
            $this->Cell($widths[$i], 5, utf8_decode($col), $border, 0, 'C');

            // eval right border
            if ($i == $col_num - 1) {
                $this->SetDrawColor(236, 0, 140);
                $this->Cell($this->GetPageWidth() - $this->GetX() - $this->rMargin, 5, '', 'R', 0, "R", 0);
            }
        }
        $this->Ln();

        // Data
        foreach ($data as $row) {
            foreach ($row as $i => $col) {
                // bold text in the first column
                $style = '';
                if ($i == 0) {
                    $style = 'B';
                }

                // eval left border
                if ($i == 0) {
                    $this->SetDrawColor(236, 0, 140);
                    $this->Cell(4.5, 5, "", 'L', 0, "R", 0);
                }

                $this->SetDrawColor(1, 38, 120);
                $this->SetFont('Helvetica', $style, 10);
                $this->Cell($widths[$i], 5, utf8_decode($col), 1, 0, 'C');

                // eval right border
                if ($i == $col_num - 1) {
                    $this->SetDrawColor(236, 0, 140);
                    $this->Cell($this->GetPageWidth() - $this->GetX() - $this->rMargin, 5, '', 'R', 0, "R", 0);
                }
            }
            $this->Ln();
        }

        $border = 'LR';
        $space = 2;
        if ($is_bottom_border) {
            $border = 'BLR';
            $space = 1;
        }
        $this->Cell($this->GetPageWidth() - $margins, $space, "", $border, 0, "R", 0);
        $this->Ln();
    }
}