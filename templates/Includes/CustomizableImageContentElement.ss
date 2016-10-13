<% if $Image %>
    <figure>
        <% if $Click == "link" %>
        <a href="$Link">
        <% else_if $Click == "modal" %>
        <a href="$Image.Url" target="_blank">
        <% end_if %>
        <% if $Orientation == "original" %>
            $Image
        <% else_if $Orientation == "landscape" %>
            <img src="$Image.Url" width="$Width" style="width:{$Width}px">
        <% else_if $Orientation == "portrait" %>
            <img src="$Image.Url" height="$Height" style="height:{$Height}px">
        <% else_if $Orientation == "cropped" %>
            $Image.CroppedImage($Width, $Height)
        <% end_if %>
        <% if $Caption %>
            <figcaption>
                $Caption
            </figcaption>
        <% end_if %>
        <% if $Click != "nothing" %>
        </a>
        <% end_if %>
    </figure>
<% end_if %>