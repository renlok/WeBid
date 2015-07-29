{XML}
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<title>{PAGE_TITLE} RSS: {RSSTITLE}</title>
		<link>{SITEURL}</link>
		<description>{PAGE_TITLE}</description>
		<copyright>Copyright {PAGE_TITLE}. The contents of this feed are available for non-commercial use only.</copyright>
		<generator>{SITEURL}</generator>
<!-- BEGIN rss -->
		<item>
			<title><![CDATA[{rss.TITLE} - {rss.PRICE}]]></title>
			<link>{rss.URL}</link>
			<guid isPermaLink="true">{rss.URL}</guid>
			<description>
				<![CDATA[{rss.DESC}<br />{rss.CAT}]]>
			</description>
			<dc:creator>{rss.USER}</dc:creator>
			<dc:date>{rss.POSTED}</dc:date>
		</item>
<!-- END rss -->
	</channel>
</rss>