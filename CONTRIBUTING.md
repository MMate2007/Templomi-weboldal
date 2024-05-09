# Közreműködés

Kezdő felhasználóknak szánt útmutatóért görgessen lejjebb!

## Közreműködési utasítások haladóknak

1. Mielőtt elkezdenénk módosítani a kódot *keressünk*, vagy *hozzunk létre* egy új **issue**-t (ha olyan módosítást végzünk melyhez létre lehet hozni; legtöbb esetben létre lehet hozni az adott problémához)! Fontos, hogy az issue-hoz pontos, bő leírást írjunk elképzelésünkről. 
2. Miután hozzánk rendelték az adott issuet (vagy akár már előtte is) elkezdhetünk dolgozni a problémán. 
3. Ha ezzel készen vagyunk készítsünk egy **pull requestet**!
4. Ezután a repository tulajdonosa hozzárendeli az issue-hoz a pull requestet, s ha mindent rendben talál merge-öli azt.

## Közreműködési utasítások kezdőknek

### Telepítés
1. Ajánlott telepíteni a Git-et számítógépre.
2. Ezek után készítsünk a repositoryról egy másolatot! Ezt a jobb felső sarokban található "Fork" gombbal tehetjük meg.
4. Nyissuk meg a Git bash terminált!
5. Navigáljunk egy mappába, ahova telepíteni szeretnék a kódot a `cd` paranccsal! A könyvtárban feljebb a `cd ..` paranccsal, lejjebb pedig a `cd \példamappa` paranccsal mehetünk.
6. Ezután írjuk be a következő parancsot: `git clone https://github.com/MMate2007/Templomi-weboldal.git`! Ezzel le is klónoztuk a repositoryt.

### Fejlesztés
1. Hozzunk létre egy ún. issue-t! Ezt felül az "Issue" fülre kattintva tehetjük meg. Írjuk le részletesen, hogy mit szeretnénk.
2. Ha a repository tulajdonosa hozzánk rendelte az issue-t elkezdhetünk dolgozni a problémán.
3. Ha végeztünk a terminálba írjuk be a `git status` parancsot! Itt láthatjuk a fájlok státuszát: mi az ami változott.
4. A módosított fájlokat adjuk hozzá a `git add fajlneve.kiterjesztes` paranccsal! Ha az összes fájl változott, akkor használjuk a `git add .` parancsot!
5. Ezután írjuk be a `git commit -m "Üzenetünk"` parancsot, ahol az Üzenetünk szó helyett írjuk be, hogy mit változtattunk.
6. Ha meg vagyunk elégedve, mehet a `git push`. Ezzel feltöltjük a **saját** repositorynkba a módosításokat.
7. Ezután hozzunk létre egy pull requestet!
8. Ha minden rendben van aa fejlesztő jóváhagyja a kódunkat!

