{XML} 

<rss version="2.0" 
	xmlns:content="http://purl.org/rss/1.0/modules/content/" 
	xmlns:wfw="http://wellformedweb.org/CommentAPI/" 
	xmlns:dc="http://purl.org/dc/elements/1.1/" 
	xmlns:atom="http://www.w3.org/2005/Atom" 
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" 
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/" 
	> 

	<channel> 
		<title>{PAGE_TITLE}: {RSSTITLE}</title> 
		<atom:link href="{SITEURL}rss.php?feed={FEED}" rel="self" type="application/rss+xml" /> 
		<link>{SITEURL}</link> 
		<description>{DESCRIPTIONTAG}</description> 
		<copyright>Copyright {PAGE_TITLE}. The contents of this feed are available for non-commercial use only.</copyright> 
		<generator>{SITEURL}</generator> 
<!-- BEGIN rss --> 
		<item> 
			<title><![CDATA[{rss.TITLE} - {rss.PRICE}]]></title> 
			<link>{rss.URL}</link> 
			<guid isPermaLink="true">{rss.URL}</guid> 
			<description><![CDATA[{rss.DESC}<br />{rss.CAT}]]></description> 
			<dc:creator>{rss.USER}</dc:creator> 
			<dc:date>{rss.POSTED}</dc:date> 
		</item> 
<!-- END rss --> 
	</channel> 
</rss>
