import os
import pathlib as p
import copy
import subprocess
import shutil

cur=p.Path.cwd()
pp=[x for x in cur.iterdir()]
ppp=[x for x in pp if not(x.is_dir())]
PP=[str(x) for x in ppp]

for j in range(len(PP)):
        k=len(PP[j])-1
        while PP[j][k]!='\\':
            k-=1
        PP[j]=PP[j][k+1:]
PPP=[x.split('.')[0] for x in PP]
PPPP=[x+'-frag.mp4' for x in PPP]

# Fragment each media file to file-frag.mp4 AND move original media files to /E?
for i in range(len(PP)):
    shit=PPP[i][1:-9]
    os.system('mkdir '+PPP[i])
    subprocess.call(['mp4fragment',PP[i],PPPP[i]])
    shutil.move(PP[i],PPP[i])

# Partition each file-frag.mp4 using mp4dash
for i in range(len(PP)):
    os.system('mp4dash -o vid'+PPPP[i][1:]+' --mpd-name=manifest.mpd --use-segment-timeline --force '+PPP[i])

#The user then has to move by hand all vid? into appropriate folders
