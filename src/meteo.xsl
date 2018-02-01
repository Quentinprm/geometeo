<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http:/www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" encoding="UTF-8" indent="yes"/>
  <xsl:template match="/previsions">
    <head>
      <title>Géométéo</title>
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/>
      <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
  	</head>
    <div id="mapid" style="height=70vh;widht:70vh">
    <xsl:apply-tempates select="./echeance"/>
  </xsl:template>

  <xsl:template match="./echeance[position() &lt; 10]">
    <div>
      <p>
        <xsl:value-of select="substring(@timestamp, 9,2)"/><xsl:value-of select="substring(@timestamp, 6,2)"/><xsl:value-of select="substring(@timestamp, 1,4)"/><xsl:value-of select="substring(@timestamp 12,2)" />h
        </br>
        <xsl:value-of select="pluie"/>mm/h
        </br>
        <xsl:value-of select="select round(((temperature/level)-273.15)*10) div 10"/>°C
      </p>
    </div>
  </xsl:template>

  <xsl:template match="text()"/>
</xsl:stylesheet>
