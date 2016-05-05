<div id="main-skip-block" role="navigation">
	<% if $PageAccessKeys %>
		<% loop $PageAccessKeys %>
		<a href="$Link" title="$Title">$Title</a>
		<% end_loop %>
	<% end_if %>
</div>