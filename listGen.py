import sys
import os
import pathlib as p

moviesOutputTxt = open('js/movies.txt','w')
showsOutputTxt = open('js/shows.txt','w')

# MOVIES
os.chdir('videos/movies')
currentPath=p.Path.cwd()
pathList=[x for x in currentPath.iterdir() if x.is_dir()]
pp=[str(x) for x in pathList]
for i in range(len(pp)):
    k=len(pp[i])-1
    while pp[i][k]!='\\':
        k-=1
    pp[i]=pp[i][k+1:]
for i in range(len(pp)):
    k=0
    while k<i and pp[k]<pp[i]:
        k+=1
    pp=pp[:k]+[pp[i]]+pp[k:i]+pp[i+1:]
for e in pp:
    #LA FAUT METTRE ID DS IWATCHED ET DS ID
    print('<div class=\"movieItem\" id=\'',e.replace(' ','_'),'\' onclick=\"MovieOverlayOn(\'',e,'\');iwatched(\'',e.replace(' ','_'),'\')\"><div class=\"movie_img_wrap\"><img src=\"videos/movies/',e,'/thumb.jpg\" width=\"100%\"><p class=\"movie_image_description\">',e,'</p></div></div>',sep='',end='',file=moviesOutputTxt)
os.chdir('..')

# TV SHOWS
os.chdir('shows')
currentPath=p.Path.cwd()
pathList=[x for x in currentPath.iterdir() if x.is_dir()]
pp=[str(x) for x in pathList]
for i in range(len(pp)):
    k=len(pp[i])-1
    while pp[i][k]!='\\':
        k-=1
    pp[i]=pp[i][k+1:]
for i in range(len(pp)):
    k=0
    while k<i and pp[k]<pp[i]:
        k+=1
    pp=pp[:k]+[pp[i]]+pp[k:i]+pp[i+1:]
for e in pp:
    print('<div class=\"showItem\" onclick=\"ShowOverlayOn(\'',e,'\')\"><div class=\"tv_img_wrap\"><img src=\"videos/shows/',e,'/thumb.jpg\"><p class=\"tv_image_description\">',e,'</p></div></div>',sep='',end='',file=showsOutputTxt)
moviesOutputTxt.close()
showsOuptutTxt.close()
