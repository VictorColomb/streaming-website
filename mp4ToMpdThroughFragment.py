import os
import pathlib as p
import copy
import subprocess
import shutil

# GRABS .mp4 OR .mkv FILES (preferably called E??.mp4/.mkv) AND TRANSFORMS THEM INTO DASH READY FILES, ORGANISED INTO vid?? DIRECTORIES (for the dash) AND E?? DIRECTORIES (for the .mp4)
# REQUIRES ffmpeg AND bento4 UTILITIES TO BE ACCESSIBLE EVERYWHERE ON THE DEVICE !!!!!!!!!!!!!

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
PPp=[x.split('.')[-1] for x in PP]
PPPP=[x+'-frag.mp4' for x in PPP]

# Fragment each media file to file-frag.mp4 AND move original media files to /E?
i=0
while i<len(PP):
    shit=PPP[i][1:-9]
    os.system('mkdir '+PPP[i])
    if PPp[i]=='mkv':
        subprocess.call(['ffmpeg','-i',PP[i],'-codec','copy',PPP[i]+'.mp4'])
        PP[i]=PPP[i]+'.mp4'
    if PPp[i] in ['mkv','mp4']:
        subprocess.call(['mp4fragment',PP[i],PPPP[i]])
        shutil.move(PP[i],PPP[i])
        i+=1
    else:
        del PP[i]
        del PPP[i]
        del PPp[i]
        del PPPP[i]

# Partition each file-frag.mp4 using mp4dash
for i in range(len(PP)):
    os.system('mp4dash -o vid'+PPPP[i][1:]+' --mpd-name=manifest.mpd --use-segment-timeline --force '+PPP[i])

#The user then has to move by hand all vid? into appropriate folders
