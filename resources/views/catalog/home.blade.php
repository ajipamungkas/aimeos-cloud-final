@extends('shop::base')

@section('aimeos_header')
	<?= $aiheader['locale/select'] ?? '' ?>
	<?= $aiheader['basket/mini'] ?? '' ?>
	<?= $aiheader['catalog/search'] ?? '' ?>
	<?= $aiheader['catalog/tree'] ?? '' ?>
	<?= $aiheader['catalog/home'] ?? '' ?>
	<?= $aiheader['cms/page'] ?? '' ?>
@stop

@section('aimeos_head_basket')
	<?= $aibody['basket/mini'] ?? '' ?>
@stop

@section('aimeos_head_nav')
	<?= $aibody['catalog/tree'] ?? '' ?>
@stop

@section('aimeos_head_locale')
	<?= $aibody['locale/select'] ?? '' ?>
@stop

@section('aimeos_head_search')
	<?= $aibody['catalog/search'] ?? '' ?>
@stop

@section('aimeos_body')
	@if(isset($aibody['catalog/home']) && !empty($aibody['catalog/home']))
		<?= $aibody['catalog/home'] ?>
	@else
		<div class="aimeos catalog-home" style="padding: 2rem; text-align: center;">
			<div class="container">
				<h1 style="color: #333; margin-bottom: 1rem;">Welcome to Your Aimeos Shop</h1>
				<p style="color: #666; font-size: 1.1rem; margin-bottom: 2rem;">
					Your e-commerce store has been successfully set up and is running in production mode.
				</p>
				<div style="background: #f8f9fa; padding: 2rem; border-radius: 8px; margin: 2rem 0;">
					<h2 style="color: #495057; margin-bottom: 1rem;">🚀 Next Steps</h2>
					<ul style="text-align: left; color: #6c757d; line-height: 1.6;">
						<li><strong>Add Products:</strong> Use the admin interface or import products</li>
						<li><strong>Configure Categories:</strong> Set up your product catalog</li>
						<li><strong>Customize Design:</strong> Adjust themes and layouts</li>
						<li><strong>Set Up Payment:</strong> Configure payment methods</li>
					</ul>
				</div>
				<div style="margin-top: 2rem;">
					<a href="/shop/search" style="background: #007bff; color: white; padding: 1rem 2rem; text-decoration: none; border-radius: 4px; display: inline-block;">
						Browse Products
					</a>
				</div>
			</div>
		</div>
	@endif
	<?= $aibody['cms/page'] ?? '' ?>
@stop
