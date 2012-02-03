<?php
/**
 * later review
 *
 * Copyright (c) 2012 Joscha Krug | marmalade.de
 * E-mail: mail@marmalade.de
 * http://www.marmalade.de
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */

/**
 * Admin controller for laterreview config tab
 */
class marm_laterreview_config extends Shop_Config
{
    /**
     * laterreview configuration template
     * @var string
     */
    protected $_sThisTemplate = "marm_laterreview_config.tpl";

    /**
     * stores array for laterreview config, with information how to display it
     * @var array
     */
    protected $_aLaterreviewConfig = null;

    /**
     * returns laterreview config array with information how to display it
     * @see marm_laterreview::getConfigForAdminGui()
     * @param bool $blReset
     * @return array
     */
    public function getLaterreviewConfig($blReset = false)
    {
        if ($this->$_aLaterreviewConfig !== null && !$blReset) {
            return $this->$_aLaterreviewConfig;
        }

        //$this->$_aLaterreviewConfig = marm_laterreview::getInstance()->getConfigForAdminGui();
        return $this->$_aLaterreviewConfig;
    }
}