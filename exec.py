import os

# Get the current working directory
directory_path = os.getcwd()
output_file_path = os.path.join(directory_path, 'combined_output.txt')

# Open the output file in write mode
with open(output_file_path, 'w') as output_file:
    # Iterate over all files in the directory
    for filename in os.listdir(directory_path):
        # Construct the full file path
        file_path = os.path.join(directory_path, filename)
        # Check if it's a file (and not a directory or the output file itself)
        if os.path.isfile(file_path) and filename != 'combined_output.txt':
            # Open and read the content of the file
            with open(file_path, 'r') as file:
                content = file.read()
                # Write the file name and its content to the output file
                output_file.write(f"{filename}: {content}\n")

print(f"Combined file has been created at {output_file_path}")
