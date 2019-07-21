import os
import sys
import pathlib as p
import subprocess

os.chdir('videos/shows')
currentPath=p.Path.cwd()
pathList=[x for x in currentPath.iterdir() if x.is_dir()]
pp=[str(x) for x in pathList]
for i in range(len(pp)):
    k=len(pp[i])-1
    while pp[i][k]!='\\':
        k-=1
    pp[i]=pp[i][k+1:]
os.chdir('..')
os.chdir('..')
for e in pp:
    subprocess.Popen([sys.executable,'epListMaker.py',e])
