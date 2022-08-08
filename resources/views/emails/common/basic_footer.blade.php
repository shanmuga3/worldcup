<div style="padding-top:0px">
	<table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;padding:0;width:100%;display:table">
		<tbody>
			<tr style="padding:0;vertical-align:top;text-align:left">
				<th style="color:#6f6f6f;font-family:'Cereal',Helvetica,Arial,sans-serif;font-weight:normal;padding:0;text-align:left;font-size:16px;line-height:19px;margin:0 auto;padding-bottom:16px;width:564px;padding-left:16px;padding-right:16px">
					<div>
						<div style="padding-top:15px">
						<hr style="max-width:580px;border-right:0;border-top:0;border-bottom:1px solid #cacaca;border-left:0;clear:both;background-color:#dbdbdb;height:2px;width:100%;border:none;margin:auto">
						</div>
						<div style="padding-top:10px;margin:0;text-align:left;margin-bottom:10px;font-family:'Cereal','Helvetica',Helvetica,Arial,sans-serif;color:#9ca299;font-size:14px;font-weight:300;line-height:1.4">
							<table align="center">
								<tr>
									@foreach(resolve("SocialMediaLink")->where('value','!=','') as $media)
									<td style="padding: 10px;margin-left: 20px;margin-right: 20px;">
										<a href="{{ $media->value }}" title="{{ ucfirst($media->name) }}" style="margin:0;padding:0;font-family:'Cereal','Helvetica',Helvetica,Arial,sans-serif;color:#ff5a5f;text-decoration:none" target="_blank" rel="noreferrer">
											<img src="{{ $site_url.'/images/email/logo_'.$media->name.'.png' }}" alt="{{ ucfirst($media->name) }}" height="40" width="40">
										</a>
									</td>
									@endforeach
								</tr>
							</table>
						</div>
					</div>
				</th>
			</tr>
		</tbody>
	</table>
</div>