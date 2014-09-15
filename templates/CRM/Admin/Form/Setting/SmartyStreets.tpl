{*
 +--------------------------------------------------------------------------+
 | Copyright IT Bliss LLC (c) 2012-2013                                     |
 +--------------------------------------------------------------------------+
 | This program is free software: you can redistribute it and/or modify     |
 | it under the terms of the GNU Affero General Public License as published |
 | by the Free Software Foundation, either version 3 of the License, or     |
 | (at your option) any later version.                                      |
 |                                                                          |
 | This program is distributed in the hope that it will be useful,          |
 | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            |
 | GNU Affero General Public License for more details.                      |
 |                                                                          |
 | You should have received a copy of the GNU Affero General Public License |
 | along with this program.  If not, see <http://www.gnu.org/licenses/>.    |
 +--------------------------------------------------------------------------+
*}
{* this template is used for setting-up the Cividesk Normalize extension *}
<div class="form-item">
    <fieldset><legend>{ts}Settings{/ts}</legend>
        <div class="crm-block crm-form-block crm-smartystreets-form-block">
        	<p>For more info on these settings visit the official <a href="http://smartystreets.com/kb/liveaddress-api/plugin/configure">SmartyStreets Configuration Page</a></p>
        	<p>If you don't have your SmartyStreets HTML key you can get it from <a href="https://smartystreets.com/account/keys">Your SmartyStreets API Page</a></p>
            <table class="form-layout-compressed">
                <tr class="crm-smartystreets-form-block">
                    <td class="label">HTML Key</td>
                    <td>{$form.HTML_KEY.html} {$form.HTML_KEY.label}</td>
                </tr>
                <tr class="crm-smartystreets-form-block">
                    <td class="label">Auto Verify</td>
                    <td>{$form.auto_verify.html} {$form.auto_verify.label}</td>
                </tr>
              
                <tr class="crm-smartystreets-form-block">
                    <td class="label">Matching Candidates</td>
                    <td>{$form.candidates.html} <br><span>{$form.candidates.label}</span></td>
                </tr>
                <tr class="crm-smartystreets-form-block">
                    <td class="label">AutoComplete Results</td>
                    <td>{$form.autocomplete.html}<br> <p>{$form.autocomplete.label}</p></td>
                </tr>
                 <tr class="crm-smartystreets-form-block">
                    <td class="label">Geolocate</td>
                    <td>{$form.geolocate.html} {$form.geolocate.label}</p></td>
                </tr>
                <tr class="crm-smartystreets-form-block">
                    <td class="label">Invalid Message</td>
                    <td>{$form.invalid.html} {$form.invalid.label}</td>
                </tr>
                <tr class="crm-smartystreets-form-block">
                    <td class="label">Ambiguous Message</td>
                    <td>{$form.ambiguous.html} {$form.ambiguous.label}</td>
                </tr>
               
            </table>
        </div>
          <fieldset><legend>{ts}Advanced Settings{/ts}</legend>
        <div class="crm-block crm-form-block crm-smartystreets-form-block">
            <table class="form-layout-compressed">
                <tr class="crm-smartystreets-form-block">
                    <td class="label">UI</td>
                    <td>{$form.UI.html} {$form.UI.label}</td>
                </tr>
                <tr class="crm-smartystreets-form-block">
                    <td class="label">Debug</td>
                    <td>{$form.debug.html} {$form.debug.label}</td>
                </tr>
            </table>
            <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="bottom"}</div>
        </div>
    </fieldset>
    </fieldset>
    
</div>
