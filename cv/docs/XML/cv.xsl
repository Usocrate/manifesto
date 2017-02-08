<?xml version="1.0"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
version="1.0">

<xsl:template match="/">
	<html>
		<head></head>
		<body><xsl:apply-templates select="cv"/></body>
	</html>
</xsl:template>

<xsl:template match="*|text()"></xsl:template>

<xsl:template match="cv">
	<h1>Identité</h1>
	<xsl:apply-templates select="identité"/>
	<h1>Coordonnées</h1>
	<xsl:apply-templates select="coordonnées"/>
	<h1>Parcours</h1>
	<xsl:apply-templates select="parcours/formation"/>
	<xsl:apply-templates select="parcours/profession"/>
	<xsl:apply-templates select="langues"/>
	<xsl:apply-templates select="loisirs"/>
</xsl:template>

<xsl:template match="identité">
	<xsl:value-of select="nom"/>&#160;<xsl:value-of select="prénom"/><br/>
	<xsl:value-of select="âge"/>
</xsl:template>

<xsl:template match="coordonnées">
	<xsl:for-each select="e-mail[@rang='principal']">
	<a>
		<xsl:attribute name="href">
			mailto:<xsl:value-of select="."/>
		</xsl:attribute>
		<xsl:value-of select="."/><br/>
	</a>
	</xsl:for-each>
	<xsl:apply-templates select="adresse"/>
</xsl:template>

<xsl:template match="formation">
	<h2>Formation</h2>
	<table cellspacing="0" cellpadding="4" border="1">
		<xsl:for-each select="diplôme">
		<tr>
			<td>
				<xsl:value-of select="@annéeObtention"/>
			</td>
			<td>
				<xsl:value-of select="intitulé"/>,&#160;
				<xsl:value-of select="école"/><br/>
				<xsl:value-of select="commentaire"/>
			</td>	
		</tr>
		</xsl:for-each>
	</table>
</xsl:template>

<xsl:template match="profession">
	<h2>Profession</h2>
	<table cellspacing="0" cellpadding="4" border="1">
	<xsl:for-each select="expérience">	
		<tr>
			<td>
				<xsl:if  test="position()=1">Depuis le<br/></xsl:if>
				<xsl:apply-templates select="période/début/date"/><br/>
				<xsl:apply-templates select="période/fin/date"/>
			</td>
			<td>
				<xsl:apply-templates select="société"/><br/>				
				<xsl:value-of select="objet"/><br/><br/>
				<xsl:apply-templates select="fonction"/><br/>
				<xsl:apply-templates select="références"/><br/>
			</td>	
		</tr>
	</xsl:for-each>
	</table>
</xsl:template>

<xsl:template match="société">
	<xsl:choose>
		<xsl:when test="url">
			<a target="_blank">
				<xsl:attribute name="href">
					<xsl:value-of select="url"/>
				</xsl:attribute>
				<xsl:value-of select="nom"/>
			</a>
		</xsl:when>
		<xsl:otherwise>
			<xsl:value-of select="nom"/>
		</xsl:otherwise>
	</xsl:choose>
	<br/>
	<xsl:apply-templates select="adresse"/><br/>
</xsl:template>
	
<xsl:template match="fonction">
	<table>
	<caption><xsl:value-of select="intitulé"/></caption>
		<xsl:for-each select="activité">
		<tr>
			<td valign="top"><xsl:value-of select="@domaine"/></td>
			<td><xsl:value-of select="."/></td>
		</tr>
		</xsl:for-each>
	</table>
</xsl:template>

<xsl:template match="références">
	<table>
	<xsl:for-each select="client">
		<tr>
			<td>
				<xsl:value-of select="nom"/><br/>(
				<xsl:value-of select="produit"/>)
			</td>
			<td>
				<ul>
					<xsl:for-each select="activité">
						<li><xsl:value-of select="."/></li>						
					</xsl:for-each>
				</ul>
			</td>
		</tr>
	</xsl:for-each>
	</table>
</xsl:template>

<xsl:template match="langues">
	<h1>Langues</h1>
	<table>
	<xsl:for-each select="langue">
		<tr>
			<td><xsl:value-of select="intitulé"></xsl:value-of></td>
			<td><xsl:value-of select="commentaire"></xsl:value-of></td>
		</tr>
	</xsl:for-each>
	</table>
</xsl:template>

<xsl:template match="loisirs">
	<h1>Loisirs</h1>
	<table>
		<xsl:for-each select="activité">
			<tr>
				<td><xsl:value-of select="@domaine"></xsl:value-of></td>
				<td><xsl:value-of select="."/></td>
			</tr>
		</xsl:for-each>
	</table>
</xsl:template>

<xsl:template match="date">
	<xsl:value-of select="jour"/>&#160;<xsl:value-of select="mois"/>&#160;<xsl:value-of select="année"/>
</xsl:template>

<xsl:template match="adresse">
	<xsl:value-of select="numéro"/>,&#160;<xsl:value-of select="voie/type"/>&#160;<xsl:value-of select="voie/nom"/><br/>
	<xsl:value-of select="ville/@codePostal"/>&#160;<xsl:value-of select="ville"/><br/>
</xsl:template>


</xsl:stylesheet>
