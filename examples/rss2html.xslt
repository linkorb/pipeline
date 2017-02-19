<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html"/>
  <xsl:template match="/">
    <html>
      <xsl:apply-templates select="/rss/channel/item"/>
    </html>
  </xsl:template>

  <xsl:template match="item">
    <div>
      <h1><xsl:value-of select="title"/></h1><xsl:text>&#10;</xsl:text>
      <p>
        <xsl:value-of disable-output-escaping="yes" select="description"/>
      </p><xsl:text>&#10;</xsl:text>
    </div>
    <xsl:text>&#10;</xsl:text>
  </xsl:template>

</xsl:stylesheet>
