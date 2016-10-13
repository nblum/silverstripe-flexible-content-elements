<table>
    <% loop $Table %>
        <% if $IsHead %>
            <tr>
                <% loop $Columns %>
                    <th>
                        $Value
                    </th>
                <% end_loop %>
            </tr>
        <% else %>
            <tr>
                <% loop $Columns %>
                    <td>
                        $Value
                    </td>
                <% end_loop %>
            </tr>
        <% end_if %>
    <% end_loop %>
</table>