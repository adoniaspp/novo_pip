<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$item = $this->getItem();
//echo "<pre>";
//        print_r($item);
//        die();
?>     
<div class="container">

    <div class="ui three column padded grid">
        <div class="three wide column"></div>
        <div class="ten wide column">
            <table class="ui compact celled definition table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Registration Date</th>
                        <th>E-mail address</th>
                        <th>Premium Plan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="collapsing">
                            <div class="ui fitted slider checkbox">
                                <input type="checkbox"> <label></label>
                            </div>
                        </td>
                        <td>John Lilki</td>
                        <td>September 14, 2013</td>
                        <td>jhlilk22@yahoo.com</td>
                        <td>No</td>
                    </tr>
                    <tr>
                        <td class="collapsing">
                            <div class="ui fitted slider checkbox">
                                <input type="checkbox"> <label></label>
                            </div>
                        </td>
                        <td>Jamie Harington</td>
                        <td>January 11, 2014</td>
                        <td>jamieharingonton@yahoo.com</td>
                        <td>Yes</td>
                    </tr>
                    <tr>
                        <td class="collapsing">
                            <div class="ui fitted slider checkbox">
                                <input type="checkbox"> <label></label>
                            </div>
                        </td>
                        <td>Jill Lewis</td>
                        <td>May 11, 2014</td>
                        <td>jilsewris22@yahoo.com</td>
                        <td>Yes</td>
                    </tr>
                </tbody>
                <tfoot class="full-width">
                    <tr>
                        <th></th>
                        <th colspan="4">
                <div class="ui right floated small primary labeled icon button">
                    <i class="user icon"></i> Add User
                </div>
                <div class="ui small button">
                    Approve
                </div>
                <div class="ui small  disabled button">
                    Approve All
                </div>
                </th>
                </tr>
                </tfoot>
            </table>       
        </div>
        <div class="three wide column"></div>
    </div>   


</div>
