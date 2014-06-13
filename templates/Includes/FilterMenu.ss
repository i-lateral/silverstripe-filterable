<% if $FilterGroups.exists %>
    <ul class="secondary filterable-groups">
        <% loop $FilterGroups %>
            <li class="filterable-group $FirstLast">
                $Title.XML

                <% if $Options.exists %>
                    <ul class="filterable-options">
                        <% loop $Options %>
                            <li class="filterable-option $FirstLast">
                                <a href="{$Link}">
                                    $Title.XML
                                </a>
                            </li>
                        <% end_loop %>
                    </ul>
                <% end_if %>
            </li>
        <% end_loop %>
    </ul>
<% end_if %>
